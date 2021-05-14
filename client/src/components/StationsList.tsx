import { MDBRow } from "mdb-react-ui-kit";
import React from "react";
import { Station, StationI } from "./Station";

export const StationsList = ({ stations }: { stations: StationI[] }) => {
  const list = stations.map((station) => (
    <Station key={station.id} station={station}/>
  ));

  return <MDBRow className="row-cols-1 row-cols-md-3 g-4">{list}</MDBRow>;
};
