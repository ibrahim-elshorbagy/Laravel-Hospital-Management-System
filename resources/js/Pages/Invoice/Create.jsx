import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import SelectInput from "@/Components/SelectInput";
import TextInput from "@/Components/TextInput";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link, useForm, router } from "@inertiajs/react";
import { useState, useEffect } from "react";
import axios from "axios";
import DoctorInvoice from "./DoctorInvoice";
import ServiceInvoice from "./ServiceInvoice";
import PackageInvoice from "./PackageInvoice";
import Select from "react-select";
export default function Create({ auth, patients, queryParams = [] }) {
    const { data, setData, post, errors } = useForm({
        selectedServices: [],
        selectedPackages: [],
        selectedDoctors: [],
        doctors: [],
        total_before_discount: 0,
        discount_value: 0,
        total_after_discount: 0,
        tax_rate: 0,
        total_with_tax: 0,
        invoice_type: "",
        clinics: [],
        services: [],
        packages: [],
        account_type: true,
        patient: { id: "", name: "", email: "" },
    });

    const [invoiceType, setInvoiceType] = useState("");

    const [manualPatient, setManualPatient] = useState(true);
    const manualPatientChange = () => {
        setManualPatient(!manualPatient);
        setData("patient", { id: "", name: "", email: "" });

        setData("account_type", !data.account_type);
        console.log(manualPatient);
    };

    useEffect(() => {
        if (invoiceType === "clinic") {
            axios
                .get("/invoice-get/clinics")
                .then((response) => {
                    setData("clinics", response.data);
                })
                .catch((error) => {
                    console.error("Error fetching clinics:", error);
                });

            data.selectedServices = [];
            data.selectedPackages = [];
        } else if (invoiceType === "service") {
            axios
                .get("/invoice-get/services")
                .then((response) => {
                    setData("services", response.data);
                })
                .catch((error) => {
                    console.error("Error fetching services:", error);
                });

            data.selectedDoctors = [];
            data.selectedPackages = [];
        } else if (invoiceType === "package") {
            axios
                .get("/invoice-get/packages")
                .then((response) => {
                    setData("packages", response.data);
                })
                .catch((error) => {
                    console.error("Error fetching packages:", error);
                });

            data.selectedDoctors = [];
            data.selectedServices = [];
        }
    }, [invoiceType]);

    useEffect(() => {
        const calculateTotals = () => {
            const selectedServices = data.selectedServices.map((service) =>
                parseFloat(service.price)
            );
            const selectedPackages = data.selectedPackages.map((pkg) =>
                parseFloat(pkg.price)
            );
            const selectedDoctors = data.selectedDoctors.map((doctor) =>
                parseFloat(doctor.price)
            );

            const totalBeforeDiscount = [
                ...selectedServices,
                ...selectedPackages,
                ...selectedDoctors,
            ].reduce((acc, price) => acc + price, 0);

            const discountValue = parseFloat(data.discount_value) || 0;
            const totalAfterDiscount = totalBeforeDiscount - discountValue;
            const taxRate = parseFloat(data.tax_rate) || 0;
            const totalWithTax =
                totalAfterDiscount + (totalAfterDiscount * taxRate) / 100;

            setData({
                ...data,
                total_before_discount: totalBeforeDiscount,
                total_after_discount: totalAfterDiscount,
                total_with_tax: totalWithTax,
            });
        };
        calculateTotals();
    }, [
        data.selectedServices,
        data.selectedPackages,
        data.selectedDoctors,
        data.discount_value,
        data.tax_rate,
        data.services,
        data.packages,
        data.doctors,
    ]);

    const onSubmit = (e) => {
        e.preventDefault();
        post(route("invoice-create.store"));
    };

  const [options, setOptions] = useState([]);
  const [selectedOption, setSelectedOption] = useState(null);

    const searchFieldChanged = (inputValue) => {
        if (!inputValue) {
            setOptions([]);
            return;
        }

        axios
            .get("/invoice-get/patients", {
                params: { search: inputValue },
            })
            .then((response) => {
                const patients = response.data;

                const formattedOptions = patients.map((patient) => ({
                    value: { id: patient.id, name: patient.name },
                    label: `${patient.name} #${patient.id}`, //here
                }));

                setOptions(formattedOptions);
            })
            .catch((error) => {
                console.error('Error fetching patients:', error);
                setOptions([]);
            });
    }

        const handlePatientChange = (selectedOption) => {
            setSelectedOption(selectedOption);
            if (selectedOption) {
                setData("patient", selectedOption.value);
            }
        };

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <div className="flex items-center justify-between">
                    <h2 className="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                        Create new Invoice
                    </h2>
                </div>
            }
        >
            <Head title="Invoices" />

            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                        <form
                            onSubmit={onSubmit}
                            className="p-6 bg-white shadow dark:bg-gray-800 sm:p-8 sm:rounded-lg"
                        >
                            <div className="flex items-center justify-center text-2xl font-bold ">
                                <hr className="flex-1 my-6 border-gray-300 dark:border-gray-700" />
                                <span className="m-4 dark:text-gray-200">
                                    Ticket Info
                                </span>
                                <hr className="flex-1 my-6 border-gray-300 dark:border-gray-700" />
                            </div>
                            {/* Select invoice type */}
                            <div className="grid h-32 grid-cols-2 gap-4">
                                <div className="mt-4">
                                    <InputLabel
                                        htmlFor="invoice_type"
                                        value="Select Invoice Type"
                                    />
                                    <SelectInput
                                        name="invoiceType"
                                        id="invoice_type"
                                        className="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50"
                                        onChange={(e) => {
                                            setInvoiceType(e.target.value),
                                                setData(
                                                    "invoice_type",
                                                    e.target.value
                                                );
                                        }}
                                    >
                                        <option value="">
                                            Select an option
                                        </option>
                                        <option value="clinic">Clinic</option>
                                        <option value="service">Service</option>
                                        <option value="package">Package</option>
                                    </SelectInput>

                                    <InputError
                                        message={errors.type}
                                        className="mt-2"
                                    />
                                </div>

                                {/* Patient */}

                                <div className="grid">
                                    <div className="flex items-center mb-2 space-x-4">
                                        <InputLabel
                                            htmlFor="patient_id"
                                            value="Patient"
                                        />
                                        <div className="flex-1">
                                            {/* Select a Patient */}
                                            {!manualPatient && (
                                                <div className="flex items-center">
                                                    <Select
                                                        className="w-full"
                                                        options={options}
                                                        value={selectedOption}
                                                        onChange={
                                                            handlePatientChange
                                                        }
                                                        onInputChange={
                                                            searchFieldChanged
                                                        }
                                                    />
                                                </div>
                                            )}
                                            {/* Write Manually Patient */}
                                            {manualPatient && (
                                                <div className="flex flex-col space-y-2">
                                                    <TextInput
                                                        name="name"
                                                        id="name"
                                                        className="block w-full border-gray-300 rounded-md shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50"
                                                        placeholder="Enter patient name"
                                                        onChange={(e) =>
                                                            setData({
                                                                ...data,
                                                                patient: {
                                                                    ...data.patient,
                                                                    id: "",
                                                                    name: e
                                                                        .target
                                                                        .value,
                                                                },
                                                            })
                                                        }
                                                    />
                                                    <TextInput
                                                        name="email"
                                                        id="email"
                                                        className="block w-full border-gray-300 rounded-md shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50"
                                                        placeholder="Enter patient email"
                                                        type="email"
                                                        onChange={(e) =>
                                                            setData({
                                                                ...data,
                                                                patient: {
                                                                    ...data.patient,
                                                                    email: e
                                                                        .target
                                                                        .value,
                                                                },
                                                            })
                                                        }
                                                    />
                                                </div>
                                            )}
                                        </div>
                                        <div className="w-auto">
                                            <button
                                                type="button"
                                                className="ml-2 text-sm text-emerald-500"
                                                onClick={manualPatientChange}
                                            >
                                                {manualPatient
                                                    ? "Select"
                                                    : "Manually"}
                                            </button>
                                        </div>
                                    </div>
                                    <InputError
                                        message={errors["patient.name"]}
                                        className="mt-2"
                                    />
                                    <InputError
                                        message={errors["patient.email"]}
                                        className="mt-2"
                                    />
                                </div>
                            </div>

                            {/* Conditional components based on invoice type */}
                            {invoiceType === "clinic" && (
                                <DoctorInvoice
                                    clinics={data.clinics}
                                    setData={setData}
                                />
                            )}
                            {invoiceType === "service" && (
                                <ServiceInvoice
                                    services={data.services}
                                    setData={setData}
                                    errors={errors}
                                />
                            )}
                            {invoiceType === "package" && (
                                <PackageInvoice
                                    packages={data.packages}
                                    setData={setData}
                                    errors={errors}
                                />
                            )}
                            <div className="flex items-center justify-center mt-20 text-2xl font-bold ">
                                <hr className="flex-1 my-6 border-gray-300 dark:border-gray-700" />
                                <span className="m-4 dark:text-gray-200">
                                    Invoice Info
                                </span>
                                <hr className="flex-1 my-6 border-gray-300 dark:border-gray-700" />
                            </div>
                            {/* Invoice Calculations */}
                            <div>
                                <div className="mt-4">
                                    <InputLabel
                                        htmlFor="total_before_discount"
                                        value="Total Before Discount"
                                    />
                                    <div className="block w-full p-2 mt-1 text-gray-700 bg-gray-100 rounded-md ">
                                        ${data.total_before_discount.toFixed(2)}
                                    </div>
                                </div>

                                {/* Discount value */}
                                <div className="mt-4">
                                    <InputLabel
                                        htmlFor="discount_value"
                                        value="Discount Value"
                                    />

                                    <TextInput
                                        id="discount_value"
                                        type="number"
                                        name="discount_value"
                                        value={data.discount_value}
                                        className="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50"
                                        onChange={(e) =>
                                            setData(
                                                "discount_value",
                                                e.target.value
                                            )
                                        }
                                    />

                                    <InputError
                                        message={errors.discount_value}
                                        className="mt-2"
                                    />
                                </div>

                                {/* Display total price after discount */}
                                <div className="mt-4">
                                    <InputLabel
                                        htmlFor="total_after_discount"
                                        value="Total After Discount"
                                    />
                                    <div className="block w-full p-2 mt-1 text-gray-700 bg-gray-100 rounded-md ">
                                        ${data.total_after_discount.toFixed(2)}
                                    </div>
                                </div>

                                {/* Tax rate */}
                                <div className="mt-4">
                                    <InputLabel
                                        htmlFor="tax_rate"
                                        value="Tax Rate (%)"
                                    />

                                    <TextInput
                                        id="tax_rate"
                                        type="number"
                                        name="tax_rate"
                                        value={data.tax_rate}
                                        className="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50"
                                        onChange={(e) =>
                                            setData("tax_rate", e.target.value)
                                        }
                                    />

                                    <InputError
                                        message={errors.tax_rate}
                                        className="mt-2"
                                    />
                                </div>

                                {/* Display total price with tax */}
                                <div className="mt-4">
                                    <InputLabel
                                        htmlFor="total_with_tax"
                                        value="Total With Tax"
                                    />
                                    <div className="block w-full p-2 mt-1 text-gray-700 bg-gray-100 rounded-md ">
                                        ${data.total_with_tax.toFixed(2)}
                                    </div>
                                </div>
                            </div>
                            <div className="mt-6 text-right">
                                <Link
                                    href={route("invoice.index")}
                                    className="px-4 py-2 mr-2 text-gray-800 transition-all bg-gray-100 rounded shadow hover:bg-gray-200"
                                >
                                    Cancel
                                </Link>
                                <button className="px-4 py-2 text-white transition-all rounded shadow bg-emerald-500 hover:bg-emerald-600">
                                    Submit
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
