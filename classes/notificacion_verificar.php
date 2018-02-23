<?php

define( 'API_ACCESS_KEY', 'AAAAXxZcEzI:APA91bHzL-xmz-NmwOcgNCb5YsIrzcpe7qrqPbeOMotgredHa476mtIt5dmth_1rwC7W1C9gQ_1qZKJfIabn9W6rtFeB11jRgr0U1OEjj1QPOXhQhzTVdhOTqySH0MHlGsP14Lqqci7c');

enviarNotificacion('Mensaje notificacion prueba','Vehículo Pendiente','121212', '123-EWQ','1090521536');

function enviarNotificacion($msj, $title, $id_factura, $placa_vehiculo, $cedula_conductor){
           
        $registrationIds[] = "fSRqKe9KWzU:APA91bFdahvxXIM0Sg6vy6oa_Bvcx9X8dxXdlVFFJyMWyr45sLUCqIJCen90wgIUvf37hYREbwf-GJaFzwsD_QL1yzN5HZ_Liiw0J_cLCBAh4owwaWW9duPPPTvG6UyY5ZJa_-xbg_Ic";
    
        $msg = array ("body" => $msj , "title" => $title, "sound" => 'default',"vibrate" =>'1');
                //];
        $dat = [
             'id_factura' => $id_factura,
             'placa_vehiculo' => $placa_vehiculo,
             'cedula_conductor' => $cedula_conductor
        ];
        $fields = [
            'registration_ids'  => $registrationIds,
            'notification' => $msg,
            'data' => $dat
        ];
        $headers = [
            'Authorization: key=' . API_ACCESS_KEY,
            'Content-Type: application/json'
        ];
        $fields = json_encode( $fields );

    
        //apt-get install -y php5-curl

        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, $fields );
        $result = curl_exec($ch );
        curl_close( $ch );
    }


