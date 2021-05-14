import React, { useEffect, useState } from "react";
import ReactDOM from "react-dom";
import "mdb-react-ui-kit/dist/css/mdb.min.css";
import { MDBContainer } from "mdb-react-ui-kit";
import { Header } from "./components/Header";
import axios from "axios";
import { StationsList } from "./components/StationsList";
import { Loading } from "./components/Loading";
import { config } from "./config";

const App = () => {
  const [stations, setStations] = useState<[]>([]);
  const [isLoading, setIsLoading] = useState<boolean>(false);
  const fetchData = async (): Promise<void> => {
    setIsLoading(true);
    const response = await axios.get(`${config.apiUrl}stations`, {
      headers: { accept: "application/json" },
    });
    console.log(response.data);
    setStations(response.data);
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
