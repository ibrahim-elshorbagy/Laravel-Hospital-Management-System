// DoctorInvoice.js
import { useState, useEffect } from "react";
import InputLabel from "@/Components/InputLabel";
import SelectInput from "@/Components/SelectInput";
import axios from "axios";

export default function DoctorInvoice({ clinics, setData }) {
    const [selectedClinic, setSelectedClinic] = useState("");
    const [doctors, setDoctors] = useState([]);

    useEffect(() => {
        if (selectedClinic) {
            axios
                .get(`/clinics/${selectedClinic}/doctors`)
                .then((response) => {
                    setDoctors(response.data);
                })
                .catch((error) => {
                    console.error("Error fetching doctors:", error);
                });
        }
    }, [selectedClinic]);

    return (
        <div className="mt-4">
            <InputLabel htmlFor="clinic" value="Select Clinic" />
            <SelectInput
                name="clinic"
                id="clinic"

                className="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50"
                onChange={(e) => {
                    setSelectedClinic(e.target.value);
                    setData("clinic", e.target.value);
                }}
            >
                <option value="">Select a Clinic</option>
                {clinics.map((clinic) => (
                    <option key={clinic.id} value={clinic.id}>
                        {clinic.name}
                    </option>
                ))}
            </SelectInput>

            {selectedClinic && (
                <div className="mt-4">
                    <InputLabel htmlFor="doctor" value="Select Doctor" />
                    <SelectInput
                        name="doctor"
                        id="doctor"
                        className="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50"
                        onChange={(e) => {
                            const selectedDoctor = doctors.find(
                                (doctor) =>
                                    doctor.id === parseInt(e.target.value)
                            );
                            setData(
                                "selectedDoctors",
                                selectedDoctor
                                    ? [
                                          {
                                              id: selectedDoctor.id,
                                              name: selectedDoctor.user.name,
                                              price: selectedDoctor.price,
                                          },
                                      ]
                                    : []
                            );
                        }}
                    >
                        <option value="">Select a Doctor</option>
                        {doctors.map((doctor) => (
                            <option key={doctor.id} value={doctor.id}>
                                {doctor.user.name} - ${doctor.price}
                            </option>
                        ))}
                    </SelectInput>
                </div>
            )}
        </div>
    );
}
