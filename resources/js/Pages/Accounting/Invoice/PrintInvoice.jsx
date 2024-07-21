import React, { useEffect } from "react";
import { Head } from "@inertiajs/react";

export default function PrintInvoice({ invoice, clinic_name }) {
    useEffect(() => {
        window.print();
    }, []);

    const renderDetails = () => {
        if (invoice.doctor) {
            const doctor = JSON.parse(invoice.doctor);
            if (doctor.length > 0) {
                return (
                    <div className="mb-2">
                        <h2 className="text-lg font-semibold">doctor</h2>
                        <ul>
                            {doctor.map((doctor, index) => (
                                <li key={index}>
                                    {doctor.name} ({clinic_name}) - $
                                    {parseFloat(doctor.price).toFixed(2)}
                                </li>
                            ))}
                        </ul>
                    </div>
                );
            }
        }
        if (invoice.services) {
            const services = JSON.parse(invoice.services);
            if (services.length > 0) {
                return (
                    <div className="mb-2">
                        <h2 className="text-lg font-semibold">Services</h2>
                        <ul>
                            {services.map((service, index) => (
                                <li key={index}>
                                    {service.name} - $
                                    {parseFloat(service.price).toFixed(2)}
                                </li>
                            ))}
                        </ul>
                    </div>
                );
            }
        }
        if (invoice.packages) {
            const packages = JSON.parse(invoice.packages);
            if (packages.length > 0) {
                return (
                    <div className="mb-2">
                        <h2 className="text-lg font-semibold">Packages</h2>
                        <ul>
                            {packages.map((pkg, index) => (
                                <li key={index}>
                                    {pkg.name} - $
                                    {parseFloat(pkg.price).toFixed(2)}
                                </li>
                            ))}
                        </ul>
                    </div>
                );
            }
        }
        return <p>No details available.</p>;
    };

    return (
        <div className="p-4 print:p-0 print:bg-white print:text-black print:shadow-none">
            <Head title="Invoice" />
            <div className="max-w-xs p-4 mx-auto bg-white shadow-md print:max-w-full print:p-0">
                <div className="mb-4 text-center">
                    <h1 className="text-2xl font-bold">Invoice</h1>
                    <p>Invoice # {invoice.id}</p>
                </div>
                <div className="mb-2">
                    <h2 className="text-lg font-semibold">
                        Patient Information
                    </h2>
                    <p>Name: {invoice.patient_name}</p>
                    {invoice.patient_id && <p>ID: {invoice.patient_id}</p>}
                </div>
                {renderDetails()}
                <div className="mb-2">
                    <h2 className="text-lg font-semibold">Totals</h2>
                    <p>
                        Total Before Discount: $
                        {parseFloat(invoice.total_before_discount).toFixed(2)}
                    </p>
                    <p>
                        Discount: $
                        {parseFloat(invoice.discount_value).toFixed(2)}
                    </p>
                    <p>
                        Total After Discount: $
                        {parseFloat(invoice.total_after_discount).toFixed(2)}
                    </p>
                    <p>Tax Rate: {invoice.tax_rate}%</p>
                    <p>
                        Total With Tax: $
                        {parseFloat(invoice.total_with_tax).toFixed(2)}
                    </p>
                </div>
            </div>
        </div>
    );
}
