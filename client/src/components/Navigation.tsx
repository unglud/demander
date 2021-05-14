import {
  MDBContainer,
  MDBNavbar,
  MDBNavbarItem,
  MDBNavbarNav,
} from "mdb-react-ui-kit";
import React, { useEffect, useState } from "react";
import { NavLink } from "react-router-dom";
import axios from "axios";
import { config } from "../config";
import { StationI } from "./Station";

export const Navigation = () => {
  const [links, setLinks] = useState();

  const fetchData = async (): Promise<void> => {
    const response = await axios.get(`${config.apiUrl}stations`, {
      headers: { accept: "application/json" },
    });
    const list = response.data.map((station: StationI, index:number) => (
      <MDBNavbarItem key={index}>
        <NavLink
          to={`/${station.id}`}
          className="nav-link"
          activeClassName="active"
        >
          {station.name}
        </NavLink>
      </MDBNavbarItem>
    ));
    setLinks(list);
  };

  useEffect(() => {
    fetchData();
  }, []);

  return (
    <header>
      <MDBNavbar expand="lg" light bgColor="white" sticky>
        <MDBContainer fluid>
          <MDBNavbarNav right className="mb-2 mb-lg-0">
            <MDBNavbarItem>
              <NavLink to="/" className="nav-link" activeClassName="active">
                Home
              </NavLink>
            </MDBNavbarItem>
            {links}
          </MDBNavbarNav>
        </MDBContainer>
      </MDBNavbar>
    </header>
  );
};
