import axios from "axios";

class Hirames {
  constructor() {
    this.axios = axios.create({
      baseURL: "https://api.hirames.com/webservise",
    });
    this.axios.defaults.headers["Authorization"] = "TOKEN_HIRAMES";
    this.axios.defaults.headers.common["Accept"] = "application/json";
    this.axios.defaults.headers.post["Content-Type"] = "application/json";
  }

  getPrice() {
    return this.axios
      .get("?query=price")
      .then((res) => {
        return res.data;
      })
      .catch((err) => {
        return false;
      });
  }

  checkWallet(wallet) {
    return this.axios
      .get(`?query=checkWallet&wallet=${wallet}`)
      .then((res) => {
        return res.data;
      })
      .catch((err) => {
        return false;
      });
  }

  createPayment(count, id, wallet) {
    return this.axios
      .post("/", {
        query: "createtransaction",
        count,
        id,
        wallet,
      })
      .then((res) => {
        return res.data;
      })
      .catch((err) => {
        return false;
      });
  }
}

export default Hirames;

// Usage example:
const hirames = new Hirames();

hirames.createPayment(10, 2122454, "fhtfhtfhfhfhtfhtf").then((price) => {
  if (price && price.key) {
    // redirect for payment
    console.log(`Redirect to: https://site.hirames.com/web/buy?key=${price.key}`);
    // In a real web server environment, you would use res.redirect() instead of console.log()
  } else {
    console.error("Payment creation failed.");
  }
});
