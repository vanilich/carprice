<?php
	class ShopModel extends BaseModel {

		/**
		* Получаем список магазинов с возможностью фильтрации по городам и автосалонам
		* @param array $shop Список ID автосалонов
		* @param array $city Список ID городов
		* @return array
		**/
		public function getShop(array $shop = [], array $city = []) {
		    $query = "SELECT id as 'shop_id', name FROM shop WHERE 1";

		    // Фильтруем данные по "городу" и "автосалону"
		    if( isset($shop) AND !empty($shop) AND is_array($shop) ) {
		    	$query .= $this->db->parse(" AND id IN(?a)", $shop);
		    }
		    if( isset($city) AND !empty($city) AND is_array($city) ) {
		    	$query .= $this->db->parse(" AND city_id IN(?a)", $city);
		    }

		    $query .= " ORDER by name DESC;";
		    
		    return $this->db->getAll($query);
		}
	}