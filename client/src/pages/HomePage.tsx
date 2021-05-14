import { Header } from "../components/Header";
import React, { useEffect, useState } from "react";
import { StationsList } from "../components/StationsList";
import { Loading } from "../components/Loading";
import axios from "axios";
import { config } from "../config";

export const HomePage = () => {
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
      <Header />
      {!isLoading && <StationsList stations={stations} />}
      {isLoading && <Loading />}
    </>
  );
};
