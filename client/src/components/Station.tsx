import {
  MDBCard,
  MDBCardBody,
  MDBCardHeader,
  MDBCol,
  MDBTable,
  MDBTableBody,
} from "mdb-react-ui-kit";
import React from "react";

export interface StationI {
  id: number;
  name: string;
  equipment:[{
    name: string;
    amount: number;
  }],
  transports: string[]
}

export const Station = ({ station }: { station: StationI }) => {
  
  const list = station.equipment.map((item, index) => (
    <tr key={index}>
      <th scope="row">{item.name}</th>
      <td>{item.amount}</td>
    </tr>
  ));
  
  return (
    <MDBCol>
      <MDBCard className="h-100">
        <MDBCardHeader className="text-center">{station.name}</MDBCardHeader>
        <MDBCardBody>
          <MDBTable small>
            <MDBTableBody>
              <tr>
                <th scope="row">Vans</th>
                <td>{station.transports.length}</td>
              </tr>
              {list}
            </MDBTableBody>
          </MDBTable>
        </MDBCardBody>
      </MDBCard>
    </MDBCol>
  );
};
