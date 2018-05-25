<?php
    /**
    * Выгружаем дамп бд на сервер
    **/
    class ExecuteSQLTask extends BaseTask {

        public function command($args) {
            if (empty($args)) {
                throw new RuntimeException("No arguments passed to command");
            }

            $migrations = $this->container->get('settings')['migration'];

            $type = $args[0];

            if( isset($migrations[$type]) ) {
                $path = $migrations[$type];

                if( file_exists($path) ) {
                    $sql = file_get_contents($path);

                    if( $this->container->db->query($sql) ) {
                        $this->container->logger->info("Migration: Success execute task");
                    } else {
                        $this->container->logger->error("Migration: Cannot execute command. Full path: " . $path);
                    }
                } else {
                    $this->container->logger->error("Migration: Cannot find sql file. Full path: " . $path);
                }
            } else {
                throw new RuntimeException("Cannot find migration type in settings.php");
            }
        }
    }