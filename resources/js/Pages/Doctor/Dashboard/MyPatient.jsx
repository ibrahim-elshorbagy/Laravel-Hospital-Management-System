import Pagination from "@/Components/Pagination";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link } from "@inertiajs/react";
import SelectInput from "@/Components/SelectInput";
import { useState } from "react";
import { router } from "@inertiajs/react";

export default function Index({ auth, patients, success }) {
    const [message, setMessage] = useState("");

    const handleChange = (e, pivot_id) => {
        const newStatus = e.target.value;

        router.post(
            route("doc.patient.change-status", { id: pivot_id }),
            {
                status: newStatus,
                pivot_id: pivot_id,
            },
            {
                preserveState: true,
                preserveScroll: true,
                onSuccess: () => {
                    setMessage(`Status updated to ${newStatus}`);
                    setTimeout(() => setMessage(""), 3000); // Clear message after 3 seconds
                },
                onError: () => {
                    setMessage("Error updating status. Please try again.");
                },
            }
        );
    };

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <div className="flex items-center justify-between">
                    <h2 className="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                        Patients
                    </h2>
                </div>
            }
        >
            <Head title="Patients" />
            <div className="py-12">
                {message ||
                    (success && (
                        <div className="p-4 mb-4 text-white bg-green-500 rounded">
                            {message || success}
                        </div>
                    ))}
                <div className="mx-auto sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                        <div className="p-6 text-gray-900 dark:text-gray-100">
                            <div className="overflow-auto">
                                <table className="w-full text-sm text-left text-gray-500 rtl:text-right dark:text-gray-400">
                                    <thead className="text-xs text-gray-700 uppercase border-b-2 border-gray-500 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <tr className="text-nowrap">
                                            <th className="px-3 py-3">ID</th>
                                            <th className="px-3 py-3">
                                                Patient Name
                                            </th>
                                            <th className="px-3 py-3">
                                                Patient Index
                                            </th>
                                            <th className="px-3 py-3">
                                                Status
                                            </th>
                                            <th className="px-3 py-3">
                                                Created At
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {patients.data.map((patient, index) => (
                                            <tr
                                                className="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                                                key={
                                                    patient.id ||
                                                    `patient-${index}`
                                                }
                                            >
                                                <td className="px-3 py-2">
                                                    {patient.id}
                                                </td>
                                                <td className="px-3 py-2">
                                                    {patient.patient_id ? (
                                                        <Link
                                                            href={route(
                                                                "doc.patient.show",
                                                                {
                                                                    id: patient.patient_id,
                                                                    invoice_id:
                                                                        patient.invoice_id,
                                                                }
                                                            )}
                                                            className="text-blue-500 dark:text-blue-400 hover:underline"
                                                        >
                                                            {
                                                                patient.patient_name
                                                            }
                                                        </Link>
                                                    ) : (
                                                        <span className="text-gray-500 dark:text-gray-400">
                                                            {
                                                                patient.patient_name
                                                            }
                                                        </span>
                                                    )}
                                                </td>
                                                <td className="px-3 py-2">
                                                    {
                                                        patient.daily_patient_index
                                                    }
                                                </td>
                                                <td className="px-3 py-2">
                                                    <SelectInput
                                                        name={`status_${patient.pivot_id}`}
                                                        id={`status_${patient.pivot_id}`}
                                                        className="block w-full mt-1"
                                                        value={patient.status}
                                                        onChange={(e) =>
                                                            handleChange(
                                                                e,
                                                                patient.pivot_id
                                                            )
                                                        }
                                                    >
                                                        <option value="pending">
                                                            Pending
                                                        </option>
                                                        <option value="entered">
                                                            Entered
                                                        </option>
                                                        <option value="completed">
                                                            Completed
                                                        </option>
                                                        <option value="canceled">
                                                            Canceled
                                                        </option>
                                                    </SelectInput>
                                                </td>
                                                <td className="px-3 py-2">
                                                    {patient.created_at}
                                                </td>
                                            </tr>
                                        ))}
                                    </tbody>
                                </table>
                            </div>
                            <Pagination links={patients.meta.links} />
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
