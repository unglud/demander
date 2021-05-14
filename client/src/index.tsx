import React, { useEffect, useState } from "react";
import ReactDOM from "react-dom";
import "mdb-react-ui-kit/dist/css/mdb.min.css";
import { MDBContainer } from "mdb-react-ui-kit";
import { Header } from "./components/Header";
import axios from "axios";
import { StationI } from "./components/Station";
import { StationsList } from "./components/StationsList";
import { Loading } from "./components/Loading";

const App = () => {
  const [stations, setStations] = useState<[]>([]);
  const [isLoading, setIsLoading] = useState<boolean>(false);
  const fetchData = async (): Promise<void> => {
    setIsLoading(true);
    const response = await axios.get("http://localhost:8000/api/stations", {
      headers: { accept: "application/json" },
    });
    const trans = response.data.map((station: StationI) => {
      return {
        id: station.id,
        name: station.name,
      };
    });

    setStations(trans);
    setIsLoading(false);
  };

  useEffect(() => {
    fetchData();
  }, []);
  return (
    <>
      {!isLoading && <StationsList stations={stations} />}
      {isLoading && <Loading />}
    </>
  );
};

ReactDOM.render(
  <React.StrictMode>
    <MDBContainer>
      <Header />
      <App />
    </MDBContainer>
  </React.StrictMode>,
  document.getElementById("root")
);
