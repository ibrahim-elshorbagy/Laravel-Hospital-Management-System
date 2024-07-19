import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import SelectInput from "@/Components/SelectInput";
import TextAreaInput from "@/Components/TextAreaInput";
import TextInput from "@/Components/TextInput";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link, useForm } from "@inertiajs/react";
import { useState, useEffect } from "react";

export default function Create({ auth, services }) {
    const { data, setData, post, errors } = useForm({
        name: "",
        description: "",
        status: "",
        selectedServices: [],
        Total_before_discount: 0,
        discount_value: 0,
        Total_after_discount: 0,
        tax_rate: 0,
        Total_with_tax: 0,
    });

    useEffect(() => {
        const calculateTotals = () => {
            const selected = data.selectedServices.map((id) => {
                const service = services.data.find(
                    (service) => service.id === parseInt(id)
                );
                return service ? parseFloat(service.price) : 0; // Ensure the price is treated as a number
            });

            const totalBeforeDiscount = selected.reduce(
                (acc, price) => acc + price,
                0
            );
            const discountValue = parseFloat(data.discount_value) || 0;
            const totalAfterDiscount = totalBeforeDiscount - discountValue;
            const taxRate = parseFloat(data.tax_rate) || 0;
            const totalWithTax =
                totalAfterDiscount + (totalAfterDiscount * taxRate) / 100;

            setData({
                ...data,
                Total_before_discount: totalBeforeDiscount,
                Total_after_discount: totalAfterDiscount,
                Total_with_tax: totalWithTax,
            });
        };
        calculateTotals();
    }, [
        data.selectedServices,
        data.discount_value,
        data.tax_rate,
        services.data,
    ]);

    const onSubmit = (e) => {
        e.preventDefault();
        post(route("package.store"));
    };

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <div className="flex items-center justify-between">
                    <h2 className="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                        Create new Package
                    </h2>
                </div>
            }
        >
            <Head title="Packages" />

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
                                    Package Info
                                </span>
                                <hr className="flex-1 my-6 border-gray-300 dark:border-gray-700" />
                            </div>
                            <div className="grid grid-cols-2 gap-4">
                                <div className="mt-4">
                                    <InputLabel
                                        htmlFor="package_name"
                                        value="Package Name"
                                    />

                                    <TextInput
                                        id="package_name"
                                        type="text"
                                        name="name"
                                        value={data.name}
                                        className="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50"
                                        isFocused={true}
                                        onChange={(e) =>
                                            setData("name", e.target.value)
                                        }
                                    />

                                    <InputError
                                        message={errors.name}
                                        className="mt-2"
                                    />
                                </div>
                                <div className="mt-4">
                                    <InputLabel
                                        htmlFor="package_status"
                                        value="Package Status"
                                    />

                                    <SelectInput
                                        name="status"
                                        id="package_status"
                                        className="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50"
                                        onChange={(e) =>
                                            setData("status", e.target.value)
                                        }
                                    >
                                        <option value="">Select Status</option>
                                        <option value="active">Active</option>
                                        <option value="inactive">
                                            Inactive
                                        </option>
                                    </SelectInput>

                                    <InputError
                                        message={errors.status}
                                        className="mt-2"
                                    />
                                </div>
                            </div>

                            <div className="mt-4">
                                <InputLabel
                                    htmlFor="package_description"
                                    value="Package Description"
                                />

                                <TextAreaInput
                                    id="package_description"
                                    name="description"
                                    value={data.description}
                                    className="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50"
                                    onChange={(e) =>
                                        setData("description", e.target.value)
                                    }
                                />

                                <InputError
                                    message={errors.description}
                                    className="mt-2"
                                />
                            </div>

                            {/* Select services */}
                            <div className="mt-4">
                                <InputLabel
                                    htmlFor="package_services"
                                    value="Select Services"
                                />

                                <SelectInput
                                    name="selectedServices"
                                    id="package_services"
                                    className="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50"
                                    multiple
                                    onChange={(e) =>
                                        setData(
                                            "selectedServices",
                                            [...e.target.selectedOptions].map(
                                                (option) => option.value
                                            )
                                        )
                                    }
                                >
                                    {services.data.map((service) => (
                                        <option
                                            key={service.id}
                                            value={service.id}
                                        >
                                            {service.name} ($
                                            {parseFloat(service.price).toFixed(
                                                2
                                            )}
                                            )
                                        </option>
                                    ))}
                                </SelectInput>

                                <InputError
                                    message={errors.selectedServices}
                                    className="mt-2"
                                />
                            </div>

                            {/* Display total price before discount */}
                            <div className="mt-4">
                                <InputLabel
                                    htmlFor="total_before_discount"
                                    value="Total Before Discount"
                                />
                                <div className="block w-full p-2 mt-1 text-gray-700 bg-gray-100 rounded-md ">
                                    ${data.Total_before_discount.toFixed(2)}
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
                                    ${data.Total_after_discount.toFixed(2)}
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
                                    ${data.Total_with_tax.toFixed(2)}
                                </div>
                            </div>

                            <div className="mt-6 text-right">
                                <Link
                                    href={route("package.index")}
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
