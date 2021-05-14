import { useParams } from "react-router-dom";
import { Navigation } from "../components/Navigation";
import React, { useEffect, useState } from "react";
import axios from "axios";
import { config } from "../config";
import { StationsList } from "../components/StationsList";
import { Loading } from "../components/Loading";

export const StationPage = () => {
  const { stationId } = useParams<{ stationId: string }>();

  const [stations, setStations] = useState<[]>([]);
  const [isLoading, setIsLoading] = useState<boolean>(false);

  const fetchData = async (id:string): Promise<void> => {
    setIsLoading(true);
    const response = await axios.get(`${config.apiUrl}stations/${id}/calendar`, {
      headers: { accept: "application/json" },
    });
    console.log(response.data);
    setStations(response.data);
    setIsLoading(false);
  };

  useEffect(() => {
    fetchData(stationId);
  }, []);

  return (
    <>
      <Navigation />
      {/*{!isLoading && <StationsList stations={stations} />}*/}
      {isLoading && <Loading />}
    </>
  );
};
