import { MDBSpinner } from "mdb-react-ui-kit";

export const Loading = () => {
  return (
    <div className="text-center">
      <MDBSpinner className="me-2" style={{ width: "3rem", height: "3rem" }}>
        <span className="visually-hidden">Loading...</span>
      </MDBSpinner>
    </div>
  );
};
