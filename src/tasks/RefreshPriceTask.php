<?php
    use \Interop\Container\ContainerInterface;
    use \Sunra\PhpSimple\HtmlDomParser;

    /**
    * Обновление цен на сайт
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
            $query = "";
            $query .= "SELECT ";
            $query .= "    price.id, ";
            $query .= "    price.url as 'price_url', ";
            $query .= "    shop.url as 'shop_url', ";
            $query .= "    shop.template as 'shop_template', ";
            $query .= "    price.template as 'price_template', ";
            $query .= "    price.updated_at, ";
            $query .= "    price.price ";
            $query .= "FROM price ";
            $query .= "    INNER JOIN shop ON ";
            $query .= "        price.active = 1 AND ";
            $query .= "        price.shop_id = shop.id AND ";
            $query .= "        price.updated_at < NOW() - INTERVAL '1' MINUTE ";
            $query .= "LIMIT 6000;";

            // Получаем данные из бд с списком не актуальных цен
            $result = $this->container->db->getAll($query);

            if(empty($result)) {
                $this->logger->info("Nothing to refresh");
                return;
            } else {
                $this->logger->info("Parse price will be starting...");
            }

            foreach ($result as $value) {
                $url = $value['price_url'];
                // Если поле template в таблице price не установлено, то берем поле template из соотвественной записи из таблицы shop
                $template = ( isset($value['price_template']) AND !empty($value['price_template']) ) ? $value['price_template'] : $value['shop_template'];

                // Проверяем ссылку на доступность
                if( $this->check404($url) !== 404 AND $this->check404($url) !== 0 ) {
                    $dom = HtmlDomParser::str_get_html( @file_get_contents($url) );

                    if($dom) {
                        // Парсим цену с помощью шаблона
                        $price = @$dom->find($template, 0)->innertext;

                        if($price) {
                            // Удаляем из цены html тэги и оставляем только цифры
                            $price = strip_tags($price);
                            $price = preg_replace("/[^0-9]/", '', $price);

                            // Обновляем значение цены в базе данных
                            $query = "UPDATE price SET price=?i, updated_at=NOW() WHERE id=?i";
                            if( $this->container->db->query($query, $price, $value['id']) ) {
                                $this->logger->info("Price with id '" . $value['id'] . "' success updated");
                            } else {
                                $this->logger->error("Price with id '" . $value['id'] . "' cannot add in DB. Full query: '" . $query . "'");
                            }
                        } else {
                            $this->container->db->query("UPDATE price SET active=0 WHERE id=?i", $value['id']);
                            $this->logger->warning($message = "Price with id '" . $value['id'] . "' cannot find in template '" . $template . "'");
                        }

                        unset($dom);
                    } else {
                        $this->container->db->query("UPDATE price SET active=0 WHERE id=?i", $value['id']);
                        $this->logger->warning("Price with id '" . $value['id'] . "' has not create dom object");                        
                    }
                } else {
                    $this->container->db->query("UPDATE price SET active=0 WHERE id=?i", $value['id']);
                    $this->logger->warning("Price with id '" . $value['id'] . "' has not 200 http response code");
                }
            }

            $this->logger->info("Parse price ending...");
        }

        public function check404($url) {
            $handle = curl_init($url);
            curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);
            $response = curl_exec($handle);
            $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
            curl_close($handle);

            return $httpCode;
        }
    }