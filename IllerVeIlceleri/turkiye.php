<?php

class turkiye{
    public  $db;
    function __construct(){
        $host="localhost";
        $dbname = "turkiye";
        $user = "root";
        $pass = "";
        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";
        try{
            $this->db = new PDO($dsn,$user,$pass);

        }catch (PDOException $e){
            echo "[HATA]: Veritabanı-".$e->getMessage();

        }

    }
    public function json_yap(){
    $query = $this->db->query("SELECT *FROM iller");
        if($query->rowCount()>0) {
            $satir = $query->fetchAll(PDO::FETCH_NAMED);
            $j=0;
            foreach($satir as $s){
                $iller[$j]["il"]=$s["il"];
                $iller[$j]["il_id"]=$s["id"];
                $sor = $this->db->prepare("SELECT *FROM ilceler WHERE il_id= ?");
                $sor->execute(array($s["id"]));
                $sorilceler = $sor->fetchAll(PDO::FETCH_NAMED);
                $k = 0;
                $ilceler = array();
                foreach($sorilceler as $t){
                    $ilceler[$k]["id"]=$t["id"];
                    $ilceler[$k]["ilce"] = $t["ilce"];
                    $k++;
                }
                $iller[$j]["ilceler"] = $ilceler;
                $j++;
            }
              return $JSON = array("TURKIYE CUMHURIYETI"=>$iller);
        }
        else{echo "hata";}
    }
}

