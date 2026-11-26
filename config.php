
<?php
/** O nome do banco de dados */
if (!defined('DB_NAME')) {
    define('DB_NAME', 'laptop');
}

/** Usuário do banco de dados MySQL */
if (!defined('DB_USER')) {
    define('DB_USER', 'root');
}

/** Senha do banco de dados MySQL */
if (!defined('DB_PASSWORD')) {
    define('DB_PASSWORD', '');
}

/** Nome do host do MySQL */
if (!defined('DB_HOST')) {
    define('DB_HOST', 'localhost');
}

/** Caminho absoluto para a pasta do sistema */
if (!defined('ABSPATH')) {
    define('ABSPATH', dirname(__FILE__) . '/');
}

/** Caminho no servidor para o sistema */
if (!defined('BASEURL')) {
    define('BASEURL', '/PW_4BI-MAIN/');
}

/** Caminho do arquivo de banco de dados */
if (!defined('DBAPI')) {
    define('DBAPI', ABSPATH . 'inc/database.php');
}

/** Template do cabeçalho */
if (!defined('HEADER_TEMPLATE')) {
    define('HEADER_TEMPLATE', ABSPATH . 'inc/header.php');
}

/** Template do rodapé */
if (!defined('FOOTER_TEMPLATE')) {
    define('FOOTER_TEMPLATE', ABSPATH . 'inc/footer.php');
}
