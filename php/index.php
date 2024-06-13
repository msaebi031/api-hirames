<?php

class Hirames {
    private $base_url;
    private $token;

    public function __construct() {
        $this->base_url = "https://api.hirames.com/webservise";
        $this->token = 'TOKEN_HIRAMES';
    }

    private function request($method, $url, $data = null) {
        $curl = curl_init();

        $headers = [
            "Authorization: " . $this->token,
            "Accept: application/json",
        ];

        if ($method == "POST") {
            $headers[] = "Content-Type: application/json";
            curl_setopt($curl, CURLOPT_POST, 1);
            if ($data) {
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
            }
        }

        if ($method == "GET" && $data) {
            $url .= '?' . http_build_query($data);
        }

        curl_setopt($curl, CURLOPT_URL, $this->base_url . $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($curl);
        curl_close($curl);

        if ($response === false) {
            return false;
        }

        return json_decode($response, true);
    }

    public function getPrice() {
        return $this->request('GET', '?query=price');
    }

    public function checkWallet($wallet) {
        return $this->request('GET', '', ['query' => 'checkWallet', 'wallet' => $wallet]);
    }

    public function createPayment($count, $id, $wallet) {
        return $this->request('POST', '/', ['query' => 'createtransaction', 'count' => $count, 'id' => $id, 'wallet' => $wallet]);
    }
}

// Usage example:
$hirames = new Hirames();
$price = $hirames->createPayment(10, 2122454, "fhtfhtfhfhfhtfhtf");
if ($price && isset($price['key'])) {
    // redirect for payment
    header("Location: https://site.hirames.com/web/buy?key=" . $price['key']);
    exit();
} else {
    echo "Payment creation failed.";
}
?>
