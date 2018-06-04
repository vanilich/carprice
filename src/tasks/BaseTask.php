<?php
    use \Interop\Container\ContainerInterface;

    abstract class BaseTask {
        protected $container;

        public function __construct(ContainerInterface $container) {
            set_time_limit(0);

            $this->container = $container;
        }    	
    }