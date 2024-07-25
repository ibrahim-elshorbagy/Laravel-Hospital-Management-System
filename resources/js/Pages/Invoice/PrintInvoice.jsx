import React, { useEffect } from "react";
import { Head } from "@inertiajs/react";

export default function PrintInvoice({ invoice_type, invoice, email, password, site }) {
    useEffect(() => {
        window.print();
    }, []);

    const renderDetails = () => {
        console.log("Invoice Type:", invoice_type);
        console.log("Invoice Data:", invoice);

        if (
            invoice_type === "clinic" &&
            invoice.doctors &&
            invoice.doctors.length > 0
        ) {
            return (
                <div className="mb-2">
                    <h2 className="text-lg font-semibold">Doctors</h2>
                    <ul>
                        {invoice.doctors.map((doctor, index) => (
                            <li key={index}>
                                Doctor: {doctor.user.name}
                                <br />
                                Price: $
                                {parseFloat(doctor.price || 0).toFixed(2)}{" "}
                                <br />
                                Number: {doctor.pivot.daily_patient_index}
                                <hr className="py-2 border-gray-300 dark:border-gray-700" />
                            </li>
                        ))}
                    </ul>
                </div>
            );
        }

        if (
            invoice_type === "service" &&
            invoice.services &&
            invoice.services.length > 0
        ) {
            return (
                <div className="mb-2">
                    <h2 className="text-lg font-semibold">Services</h2>
                    <ul>
                        {invoice.services.map((service, index) => (
                            <li key={index}>
                                {service.name} - $
                                {parseFloat(service.price || 0).toFixed(2)}
                                <br />
                                Number: {service.pivot.daily_patient_index}
                                <hr className="py-2 border-gray-300 dark:border-gray-700" />
                            </li>
                        ))}
                    </ul>
                </div>
            );
        }

        if (
            invoice_type === "package" &&
            invoice.services &&
            invoice.services.length > 0
        ) {
            return (
                <div className="mb-2">
                    <h2 className="text-lg font-semibold">Package Details</h2>
                    <ul>
                        {invoice.services.map((service, index) => (
                            <li key={index}>
                                {service.name} - $
                                {parseFloat(service.price || 0).toFixed(2)}
                                <br />
                                Number: {service.pivot.daily_patient_index}
                                <hr className="py-2 border-gray-300 dark:border-gray-700" />
                            </li>
                        ))}
                    </ul>
                </div>
            );
        }

        return <p>No details available.</p>;
    };

    return (
        <div className="p-4 print:p-0 print:bg-white print:text-black print:shadow-none">
            <Head title="Invoice" />
            <div className="max-w-xs p-4 mx-auto bg-white shadow-md print:max-w-full print:p-0">
                <div className="mb-4 text-center">
                    <h1 className="text-2xl font-bold">Invoice</h1>
                </div>
                <div className="mb-2">
                    <h2 className="text-lg font-semibold">
                        Patient Information
                    </h2>
                    <p>Name: {invoice.name}</p>
                    {invoice.patient_id && <p>ID: #{invoice.patient_id}</p>}
                    {email && <p>Email: {email}</p>}
                    {password && <p>Password: {password}</p>}
                </div>
                {renderDetails()}
                <div className="mb-2">
                    <h2 className="text-lg font-semibold">Totals</h2>
                    <p>
                        Total Before Discount: $
                        {parseFloat(
                            invoice.details.total_before_discount || 0
                        ).toFixed(2)}
                    </p>
                    <p>
                        Discount: $
                        {parseFloat(
                            invoice.details.discount_value || 0
                        ).toFixed(2)}
                    </p>
                    <p>
                        Total After Discount: $
                        {parseFloat(
                            invoice.details.total_after_discount || 0
                        ).toFixed(2)}
                    </p>
                    <p>Tax Rate: {invoice.details.tax_rate}%</p>
                    <p>
                        Total With Tax: $
                        {parseFloat(
                            invoice.details.total_with_tax || 0
                        ).toFixed(2)}
                    </p>
                    <hr className="my-2 border-gray-300 dark:border-gray-700" />

                    {site && <p>Site: {site}</p>}
                </div>
            </div>
        </div>
    );
}
