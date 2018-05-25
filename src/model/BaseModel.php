<?php
	abstract class BaseModel {

		protected $db;

		public function __construct(SafeMySQL $instance) {
			$this->db = $instance;
		}
	}