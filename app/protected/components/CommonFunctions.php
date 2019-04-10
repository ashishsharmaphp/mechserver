<?php

class CommonFunctions {

    public static function sendEmail($subject, $email, $msg) {

        $msg.= "<br/><br/> Email will be sent to: $email";

        $mail = Yii::app()->Smtpmail;

        $mail->SetFrom(Yii::app()->params['adminEmail'], Yii::app()->params['adminName']);

        $mail->AddAddress($email); 
        $mail->AddCC('ashish.sharma.php@gmail.com');
        $mail->AddCC('vinitmishra9@gmail.com');
        $mail->AddCC('aarti1225mourya@gmail.com');

        $mail->Subject = $subject; 
        $mail->MsgHTML($msg);

        if (!$mail->Send()) {
            echo '<pre>';
            print_r($mail->ErrorInfo);
            die;
        }
    }

    public static function getLocationDetail($latitude, $longitude) {

        $locationDetails = "";
        $geolocation = $latitude . ',' . $longitude;

        $request = 'http://maps.googleapis.com/maps/api/geocode/json?latlng=' . $geolocation . '&sensor=false';
        $file_contents = file_get_contents($request);
        $json_decode = json_decode($file_contents);


        if (isset($json_decode->results[0])) {
            $locationDetails = $json_decode->results[0]->formatted_address;
        }

        return $locationDetails;
    }

    /**
     * Returns the nearby mechanics
     * 
     * @param string $lat
     * @param string $long
     * @param int $service_id
     * @param boolean $limit
     * @return type
     */
    public static function getNearbyMechanics($lat, $long, $service_id, $limit = false) {

        if ($limit) {
            $lim = "limit 1";
        } else {
            $lim = "LIMIT 0 , 20";
        }

        $SQL = "SELECT 
                    t.`mech_id`, m.`name`, m.`email`, m.`mobile`, t.`lat`, t.`long`, m.`device_token`, m.`os`, ( 6371 * acos( cos( radians($lat) ) * cos( radians( t.`lat` ) ) * cos( radians( t.`long` ) - radians($long) ) + sin( radians($lat) ) * sin( radians( t.`lat` ) ) ) ) AS distance 

                    FROM track_master t, mech_master m, mech_service ms
                    WHERE 
                        t.`mech_id` = m.`id`
                    AND
                        ms.`mech_id` = t.`mech_id`
                    AND
                        ms.`service_id` = $service_id
                    AND
                        m.`email_valid` = 1 AND m.`mobile_valid` = 1  AND m.`is_active` = 1  AND m.`is_busy` = 0  AND m.`is_logged_in` = 1 ORDER BY distance $lim";
        //HAVING distance < 25 

        $result = Yii::app()->db->createCommand($SQL)->queryAll();

        return $result;
    }

    /**
     * Send the apple push notf and sends the response to user
     * @param string $message
     * @param string $deviceToken
     * @return string $data
     */
    public static function sendIphonePush($message, $deviceToken) {

        // Put your private key's passphrase here:
        $passphrase = '123456';

        ////////////////////////////////////////////////////////////////////////////////
        $ctx = stream_context_create();
        stream_context_set_option($ctx, 'ssl', 'local_cert', '/var/www/html/mechserver/app/protected/components/MechVoip.pem');
        stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

        // Open a connection to the APNS server
        $fp = stream_socket_client(
                'ssl://gateway.sandbox.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);

        if (!$fp)
            exit("Failed to connect: $err $errstr" . PHP_EOL);

        //echo 'Connected to APNS' . PHP_EOL;
        // Create the payload body

        $body['aps'] = $message;

        // Encode the payload as JSON
        $payload = json_encode($body);

        // Build the binary notification
        $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

        // Send it to the server
        $result = fwrite($fp, $msg, strlen($msg));

        if (!$result)
            $data = 'Message not delivered' . PHP_EOL;
        else
            $data = 'Message successfully delivered' . PHP_EOL;

        // Close the connection to the server
        fclose($fp);

        return $data;
    }

    public static function sendAndroidPush($message, $deviceToken) {
        $path_to_firebase_cm = 'https://fcm.googleapis.com/fcm/send';
        $serverKey = 'AIzaSyDEsuH5A3eUQ4hoAMC15-vAOYXuKtky-VU';
        $senderId = "661929464856";

        $fields = array(
            'to' => $deviceToken,
            'notification' => array('title' => 'Working Good', 'body' => $message),
            'data' => array('message' => $message)
        );

        $headers = array(
            "Authorization:key = $serverKey",
            'Content-Type:application/json'
        );
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $path_to_firebase_cm);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        $result = curl_exec($ch);

        curl_close($ch);

        return $message;
    }

    /**
     * Returns the details of request raiser
     * 
     * @param int $requestId
     * @return array $result
     */
    public static function getRequestRaiserDetails($requestId) {

        $SQL = "SELECT u.* 
                FROM `user_master` u, `request_master` rm
                WHERE 
                    rm.`id` = $requestId
                AND 
                    rm.`user_id` = u.`id`";

        $result = Yii::app()->db->createCommand($SQL)->queryRow();

        return $result;
    }

    /**
     * Returns the details of mechanic
     * @param type $mechId
     * @return type
     */
    public static function getMechanicInfo($mechId) {
        $SQL = "SELECT * FROM `mech_master` where `id` = $mechId";

        $result = Yii::app()->db->createCommand($SQL)->queryRow();
        return $result;
    }

    /**
     * Returns the average ratings of mechanic
     * @param type $mechId
     * @return type
     */
    public static function getMechanicRatings($mechId) {
        $SQL = "SELECT AVG(`rating`) FROM `mech_ratings` WHERE `mech_id` = $mechId";

        $result = Yii::app()->db->createCommand($SQL)->queryScalar();

        return round($result);
    }

    /**
     * Returns the full details of services with full mechanic info
     * @param int $mechId
     * @return object $result
     */
    public static function getMechanicServices($mechId) {

        $result['mechInfo'] = (array) self::getMechanicInfo($mechId);

        $SQL = "SELECT 
                    sm.*, ms.price, ms.comments
                FROM `mech_master` m
                JOIN `mech_service` ms
                JOIN `services_master` sm
                WHERE 
                    m.`id` = ms.`mech_id` 
                AND 
                    sm.`id` = ms.`service_id` 
                AND 
                    m.`id` = $mechId";

        $result['services'] = Yii::app()->db->createCommand($SQL)->queryAll();
        return $result;
    }

    public static function getMechanicAssignedtoRequest($reqId) {
        $SQL = "SELECT mech_master.*
                FROM 
                    mech_master, request_master
                WHERE 
                    mech_master.id = request_master.user_id
                AND
                    request_master.status = 2
                AND
                    request_master.related_req_id = $reqId LIMIT 1;";

        $result = Yii::app()->db->createCommand($SQL)->queryRow();
        return $result;
    }

    /**
     * Random string generator
     * 
     * @param integer $length
     * @return string $randomString
     */
    public static function generateRandomString($length = 20) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public static function getRequestVehicalDetails($reqId) {

        $SQL = "SELECT 
                    rq.vehical_type, rq.fuel, mk.make, md.model
                FROM `request_vehical_details` rq
                JOIN `vehical_make_master` mk
                JOIN `vehical_model_master` md
                WHERE 
                    rq.`request_id` = $reqId AND rq.make = mk.id AND rq.model = md.id";

        $result = Yii::app()->db->createCommand($SQL)->queryRow();
        return $result;
    }

    public static function getServiceStatus($statusId) {
        $statusArr = array(
            1 => 'Service Request Raised By User', 2 => 'Service Request Accepted By Machanic', 3 => 'Service Started', 4 => 'Service Completed', 5 => 'Payment Done', 6 => 'Mechanic Busy'
        );

        return $statusArr[$statusId];
    }

}
