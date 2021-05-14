import React from "react";
import ReactDOM from "react-dom";
import { BrowserRouter, Route } from "react-router-dom";
import "mdb-react-ui-kit/dist/css/mdb.min.css";
import { HomePage } from "./pages/HomePage";
import { StationPage } from "./pages/StationPage";

ReactDOM.render(
  <React.StrictMode>
    <BrowserRouter>
      <Route path="/">
        <HomePage />
      </Route>
      <Route path="/station">
        <StationPage />
      </Route>
    </BrowserRouter>
  </React.StrictMode>,
  document.getElementById("root")
);
