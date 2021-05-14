import React, { useEffect, useState } from "react";
import ReactDOM from "react-dom";
import "mdb-react-ui-kit/dist/css/mdb.min.css";
import { MDBContainer } from "mdb-react-ui-kit";
import { Header } from "./components/Header";
import axios from "axios";
import { StationI } from "./components/Station";
import { StationsList } from "./components/StationsList";

const App = () => {
  const [stations, setStations] = useState<[]>([]);
  const fetchData = () => {
    axios.get("http://localhost:8000/api/stations", {
      headers: { accept: "application/json" },
    }).then((response) => response.data).then((data) => {
      const trans = data.map((station: StationI) => {
        return {
          id: station.id,
          name: station.name,
        };
      });

      setStations(trans);
    });
  };

  useEffect(() => {
    fetchData();
  }, []);
  return <StationsList stations={stations}/>;
};

ReactDOM.render(
  <React.StrictMode>
    <MDBContainer>
      <Header/>
      <App/>
    </MDBContainer>
  </React.StrictMode>,
  document.getElementById("root")
);

