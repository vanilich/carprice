<?php
    /**
    * Выполение призвольного SQL кода на сервере
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

                    $host = $this->container->get('settings')['db']['host'];
                    $user = $this->container->get('settings')['db']['user'];
                    $pass = $this->container->get('settings')['db']['pass'];
                    $db = $this->container->get('settings')['db']['db'];

                    $db = new PDO('mysql:host=' . $host . ';dbname=' . $db . ';charset=UTF8', $user, $pass);

                    $result = $db->exec($sql);
                    
                    if( $result !== false ) {
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