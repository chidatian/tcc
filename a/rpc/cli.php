<?php

for ( $i=1; $i< 2; $i++) {

    $yar = new Yar_Client("tcp://127.0.0.1:9090");
    $yar->SetOpt(YAR_OPT_CONNECT_TIMEOUT, 3000);
    
    print_r($yar->query('test',[1,2,3,4],2,3,4,5));



}
