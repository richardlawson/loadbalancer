<?php
if($_SERVER['SERVER_NAME'] == 'localhost'){
	class Config{
		const  DB_HOST = "127.0.0.1";
		const  DB_USERNAME = "root";
		const  DB_PASSWORD = "aberdeen";
		const  DB_NAME = "test";
		const  SITE_EMAIL = "info@flipshark.co.uk";
		const  SITE_EMAIL_PASS = "aberdeen31";
	}
}else{
	class Config{
		//const  DB_HOST = "172.30.0.252";
		const  DB_HOST = "flipsharkdbinstance.chf3iff6id95.eu-west-1.rds.amazonaws.com";
		const  DB_USERNAME = "root";
		const  DB_PASSWORD = "aberdeen";
		const  DB_NAME = "test";
		const  SITE_EMAIL = "info@flipshark.co.uk";
		const  SITE_EMAIL_PASS = "aberdeen31";
	}
}