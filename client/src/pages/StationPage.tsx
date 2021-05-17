import { useParams } from "react-router-dom";
import { Navigation } from "../components/Navigation";
import React, { useEffect, useState } from "react";
import axios from "axios";
import { config } from "../config";
import { Loading } from "../components/Loading";
import { CalendarList } from "../components/CalendarList";
import { MDBTypography } from "mdb-react-ui-kit";

export const StationPage = () => {
  const { stationId } = useParams<{ stationId: string }>();

  const [calendars, setCalendars] = useState<[]>([]);
  const [isLoading, setIsLoading] = useState<boolean>(false);

  const fetchData = async (id: string): Promise<void> => {
    setIsLoading(true);
    const response = await axios.get(
      `${config.apiUrl}stations/${id}/calendar`,
      {
        headers: { accept: "application/json" },
      }
    );
    console.log(response.data);
    setCalendars(response.data);
    setIsLoading(false);
  };

  useEffect(() => {
    fetchData(stationId);
  }, [stationId]);

  return (
    <>
      <Navigation />
      <MDBTypography note noteColor='primary'>
        Number in <strong>(brackets)</strong> equals to number of items in order which will arrive to this station
      </MDBTypography>
      {!isLoading && <CalendarList calendars={calendars} />}
      {isLoading && <Loading />}
    </>
  );
};
