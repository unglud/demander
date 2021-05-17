import { MDBRow } from "mdb-react-ui-kit";
import React from "react";
import { Calendar, CalendarI } from './Calendar';

export const CalendarList = ({ calendars }: { calendars: CalendarI[] }) => {
  const list = calendars.map((day, index) => (
    <Calendar key={index} day={day}/>
  ));

  return <MDBRow className="row-cols-1 row-cols-md-3 g-4">{list}</MDBRow>;
};
