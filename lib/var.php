<?
error_reporting(E_ALL); 

session_start();

$string="ptindomomulia";

// koneksi database sqlserver dbsindomo
$server="192.168.1.21";
//$server="DBSINDOMO";
//$server="192.168.0.6";
$username="sa";
$password="ptim*328";
$database="komisi";

$connectionInfo = array( "UID"=>$username,
                         "PWD"=>$password,
                         "Database"=>$database);

$conn = sqlsrv_connect($server, $connectionInfo) or die("gagal konek : ".print_r(sqlsrv_errors()));

@define("INCLUDE_PATH",__DIR__ . "/pear");

//koneksi smtp email
define("EMAIL_DIAKTIFKAN", true);
define("SMTP_HOST","192.168.1.20");
define("SMTP_AUTH",false);
define("SMTP_USERNAME","support@modena.co.id");
define("SMTP_PASSWORD","000000");
define("CRLF","\n");
define("EMAIL_TEMPLATE", "template/email.html");

// data tujuan email
define("SUPPORT_EMAIL", "support@modena.co.id");
define("AKUNTING_TO", "admin.acc2@modena.co.id");
$arr_email_cabang = array("Bali.sales@modena.co.id",
"Bandung.sales@modena.co.id",
"Makassar.sales@modena.co.id",
"Medan.sales@modena.co.id",
"Samarinda.sales@modena.co.id",
"Semarang.sales@modena.co.id",
"Surabaya.sales1@modena.co.id",
"Surabaya.sales2@modena.co.id",
"Banjarmasin.sales@modena.co.id",
"Yogyakarta.sales@modena.co.id",
"Palembang.sales@modena.co.id",
"Lampung.sales@modena.co.id",
"Purwokerto.sales@modena.co.id",
"Kediri.sales@modena.co.id",
"Manado.sales@modena.co.id",
"Malang.sales@modena.co.id",
"Pekanbaru.sales@modena.co.id",
"Pontianak.sales@modena.co.id");

$arr_email_app = array("fauzi.atmaja@modena.co.id");
$email_tm = "muhammad.ilham@modena.co.id,bahrudin@modena.co.id,Fitria.Sisco@modena.co.id";
$email_pph = "sonny.arief@modena.co.id";


$arr_month=array(1=>"Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");

// koneksi mysql ke dmz
$server="192.182.10.2";
$username="root";
$password="ducksterx_1981";
$db_mysql = "nolppco_modena";
//$db_mysql = "dev_nolppco";

?>