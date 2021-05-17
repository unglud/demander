import {
  MDBCard,
  MDBCardBody,
  MDBCardHeader,
  MDBCol,
  MDBTable,
  MDBTableBody,
} from "mdb-react-ui-kit";
import React from "react";

export interface CalendarI {
  id: number;
  date: string;
  weekend: boolean;
  equipment: [
    {
      name: string;
      amount: number;
    }
  ];
  transports: number;
}

export const Calendar = ({ day }: { day: CalendarI }) => {
  const list = day.equipment?.map((item, index) => (
    <tr key={index}>
      <th scope="row">{item.name}</th>
      <td>{item.amount}</td>
    </tr>
  ));

  return (
    <MDBCol>
      <MDBCard className="h-100" border={day.weekend ? "danger" : ""}>
        <MDBCardHeader className={`text-center ${day.weekend ? "text-danger" : ""}`}>{day.date}</MDBCardHeader>
        <MDBCardBody>
          <MDBTable small>
            <MDBTableBody>
              <tr>
                <th scope="row">Vans</th>
                <td>{day.transports}</td>
              </tr>
              {list}
            </MDBTableBody>
          </MDBTable>
        </MDBCardBody>
      </MDBCard>
    </MDBCol>
  );
};
