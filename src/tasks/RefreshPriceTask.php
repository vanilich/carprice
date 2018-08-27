<?php
use \Interop\Container\ContainerInterface;
use \Sunra\PhpSimple\HtmlDomParser;

/**
 * Обновление цен на сайт
 *  Параметры:
 *      shop_id=1           // Id Магазина
 *      time=false          // Отключить интервал
 *      limit=100           // Лимит записей для обновления
 *      active=2            // Принудительно установить статус поля 'active'
 *      id=1                // Конкретный id с ценой
 *      not_shop_id=12,1,2  // Кроме этих магазинов
 **/
class RefreshPriceTask extends BaseTask {

    protected $logger;

    public function __construct($container) {
        parent::__construct($container);

        $filename = 'parse-price-' . date("Y-m-d H.i.s") . '.log';

        $settings = [
            'name' => 'refresh-price',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../../logs/' . $filename,
            'level' => \Monolog\Logger::DEBUG,
        ];

        $this->logger = new Monolog\Logger($settings['name']);
        $this->logger->pushProcessor(new Monolog\Processor\UidProcessor());
        $this->logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    }

    public function command($args) {
        $params = [];
        // Перебираем входные аргументы
        foreach ($args as $value) {
            // Пробел - разделитель
            $tmp = @explode("=", $value);

            // Получаем имя и значение аргументов
            $paramName = $tmp[0];
            $paramValue = $tmp[1];

            if(!$paramName OR !$paramValue) {
                die("Unknown params \n");
            }

            // Положим их в массив
            $params[$paramName] = $paramValue;
        }

        $query = "";
        $query .= "SELECT ";
        $query .= "    price.id, ";
        $query .= "    price.url as 'price_url', ";
        $query .= "    shop.url as 'shop_url', ";
        $query .= "    shop.template as 'shop_template', ";
        $query .= "    shop.use_proxy as 'use_proxy', ";
        $query .= "    price.template as 'price_template', ";
        $query .= "    price.updated_at, ";
        $query .= "    price.price ";
        $query .= "FROM price ";
        $query .= "    INNER JOIN shop ON ";

        // Принудииельно устанавливаем статус
        if( isset($params['active'])  ) {
            $query .= $this->container->db->parse("price.active = ?i AND ", $params['active']);
        } else {
            $query .= "price.active IN (0, 1, 2, 3) AND ";
        }

        $query .= "        price.shop_id = shop.id AND ";

        // Если передали ID Магазина
        if( isset($params['shop_id']) ) {
            $query .= $this->container->db->parse("price.shop_id = ?i AND ", $params['shop_id']);
        }

        // Если передали ID НЕ Магазина
        if( isset($params['not_shop_id']) ) {
            $query .= $this->container->db->parse("price.shop_id NOT IN(?s) AND ", $params['not_shop_id']);
        }

        // Если передали ID Цены
        if( isset($params['id']) ) {
            $query .= $this->container->db->parse("price.id = ?i AND ", $params['id']);
        }

        // Отключаем проверку по интервалу
        if( isset($params['time']) AND $params['time'] == 'false' ) {
            $query .= "1 "; // null query
        } else {
            $query .= "price.updated_at < NOW() - INTERVAL '720' MINUTE "; // 12 часов
        }

        // Лимит записей на обновление
        if( isset($params['limit']) ) {
            $query .= $this->container->db->parse("ORDER BY price.active LIMIT ?i;", $params['limit']);
        } else {
            $query .= "ORDER BY price.active LIMIT 1000;";
        }

        // Получаем данные из бд с списком не актуальных цен
        $result = $this->container->db->getAll($query);

        if(empty($result)) {
            $this->logger->info("Nothing to refresh");
            return;
        } else {
            $this->logger->info("Parse price will be starting...");
        }

        foreach ($result as $value) {
            // Ссылка на ID c ценой
            $id = $value['id'];
            // Ссылка на страницу с ценой
            $url = $value['price_url'];
            // Использовать ли прокси
            $useProxy = intval($value['use_proxy']);
            // Если поле template в таблице price не установлено, то берем поле template из соотвественной записи из таблицы shop
            $template = ( isset($value['price_template']) AND !empty($value['price_template']) ) ? $value['price_template'] : $value['shop_template'];

            // Создаем модель для цены
            $priceModel = new PriceModel($this->container->db);

            try {
                // Парсим цену сайта
                $price = PriceModel::parse($url, $template, $useProxy);

                // Обновляем новое значение цены
                $priceModel->updatePrice(PriceModel::PRICE_SUCCESS, $id, $url, $price);
                $this->logger->info("Price with id '" . $value['id'] . "' success updated");
            } catch(\PriceException $exp) {
                // Если такой DOM элемент не найден на странице
                if($exp->getLevel() == PriceModel::DOM_ENTITY_NOT_FOUND) {
                    $priceModel->updatePrice(PriceModel::DOM_ENTITY_NOT_FOUND, $id, $url);
                    $this->logger->warning("Price with id '" . $value['id'] . "' cannot find in template '" . $template . "'");
                }

                // Если хост с ценой не найден
                if($exp->getLevel() == PriceModel::HOST_NOT_FOUND) {
                    $priceModel->updatePrice(PriceModel::HOST_NOT_FOUND, $id, $url);
                    $this->logger->warning("Price with id '" . $value['id'] . "' has not 200 http response code");
                }
            } catch(\Exception $exp) {}
        }

        $this->logger->info("Parse price ending..."); 
    }
}