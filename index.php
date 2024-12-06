<?php

function getWeather($city) {
    // Şehir adını kontrol et
    if (empty($city) || !is_string($city)) {
        die(json_encode(["error" => "Geçerli bir şehir adı giriniz."], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    }

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.collectapi.com/weather/getWeather?data.lang=tr&data.city=" . urlencode($city),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "authorization: apikey 5F9g1Z8xkrj5Usz1Brrdgg:2wlwmVWE2yJPeGi44zKkuG",
            "content-type: application/json"
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    // Hata kontrolü
    if ($err) {
        // JSON formatında hata mesajı döndür
        echo json_encode(["error" => "cURL Hatası: $err"], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    } else {
        // Gelen yanıtı JSON olarak çözümle
        $decodedResponse = json_decode($response, true);

        // Eğer geçersiz bir yanıt dönerse
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo json_encode(["error" => "Geçersiz JSON yanıtı alındı."], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        } else {
            // Yanıtı JSON olarak düzgün şekilde yazdır
            echo json_encode($decodedResponse, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
    }
}

// Örnek kullanım
getWeather("Ankara");
