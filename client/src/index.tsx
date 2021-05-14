import React from "react";
import ReactDOM from "react-dom";
import { BrowserRouter as Router, Route, Switch } from "react-router-dom";
import "mdb-react-ui-kit/dist/css/mdb.min.css";
import { StationPage } from "./pages/StationPage";
import { MDBContainer } from "mdb-react-ui-kit";
import { HomePage } from './pages/HomePage';

ReactDOM.render(
  <React.StrictMode>
    <Router>
      <MDBContainer>
        <Switch>
          <Route path="/:stationId">
            <StationPage />
          </Route>
          <Route path="/">
            <HomePage />
          </Route>
        </Switch>
      </MDBContainer>
    </Router>
  </React.StrictMode>,
  document.getElementById("root")
);
