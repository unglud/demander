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
}

export const Station = ({ station }: { station: StationI }) => {
  return (
    <MDBCol>
      <MDBCard className="h-100">
        <MDBCardHeader className="text-center">{station.name}</MDBCardHeader>
        <MDBCardBody>
          <MDBTable small>
            <MDBTableBody>
              <tr>
                <th scope="row">Vans</th>
                <td>2</td>
              </tr>
              <tr>
                <th scope="row">Toilets</th>
                <td>3</td>
              </tr>
              <tr>
                <th scope="row">Sleeping bags</th>
                <td>5</td>
              </tr>
            </MDBTableBody>
          </MDBTable>
        </MDBCardBody>
      </MDBCard>
    </MDBCol>
  );
};
