import os
import requests

class Hirames:
    def __init__(self):
        self.base_url = "https://api.hirames.com/webservise"
        self.headers = {
            "Authorization": 'TOKEN_HIRAMES',
            "Accept": "application/json",
            "Content-Type": "application/json"
        }

    def get_price(self):
        try:
            response = requests.get(f"{self.base_url}?query=price", headers=self.headers)
            response.raise_for_status()
            return response.json()
        except requests.RequestException:
            return False

    def check_wallet(self, wallet):
        try:
            response = requests.get(f"{self.base_url}?query=checkWallet&wallet={wallet}", headers=self.headers)
            response.raise_for_status()
            return response.json()
        except requests.RequestException:
            return False

    def create_payment(self, count, id, wallet):
        try:
            payload = {
                "query": "createtransaction",
                "count": count,
                "id": id,
                "wallet": wallet
            }
            response = requests.post(self.base_url, json=payload, headers=self.headers)
            response.raise_for_status()
            return response.json()
        except requests.RequestException:
            return False

# Usage example:
hirames = Hirames()
price = hirames.create_payment(10, 2122454, "fhtfhtfhfhfhtfhtf")
if price and 'key' in price:
    # redirect for payment
    print(f"Redirect to: https://site.hirames.com/web/buy?key={price['key']}")
    # In a real web server environment, you would use an appropriate redirection method
else:
    print("Payment creation failed.")