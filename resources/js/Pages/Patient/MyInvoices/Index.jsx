import Pagination from "@/Components/Pagination";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link } from "@inertiajs/react";

export default function Index({ auth, invoices }) {
    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <div className="flex items-center justify-between">
                    <h2 className="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                        Invoices
                    </h2>
                    <Link
                        href={route("patient.create")}
                        className="px-3 py-1 text-white transition-all rounded shadow bg-emerald-500 hover:bg-emerald-600"
                    >
                        Add new
                    </Link>
                </div>
            }
        >
            <Head title="Invoices" />

            <div className="py-12">
                <div className="mx-auto sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                        <div className="p-6 text-gray-900 dark:text-gray-100">
                            <div className="overflow-auto">
                                <table className="w-full text-base text-left text-gray-400">
                                    {" "}
                                    {/* Increased font size */}
                                    <thead className="bg-gray-800">
                                        <tr>
                                            <th className="px-3 py-2">ID</th>
                                            <th className="px-3 py-2">
                                                Invoice Type
                                            </th>
                                            <th className="px-3 py-2">
                                                Doctor/Service
                                            </th>
                                            <th className="px-3 py-2">
                                                Total Cost
                                            </th>
                                            <th className="px-3 py-2">
                                                Created At
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {invoices.data.map((invoice) => (
                                            <>
                                                <tr
                                                    className={`border-gray-700  `}
                                                    key={invoice.id}
                                                >
                                                    <td className="px-3 py-2">
                                                        {invoice.id}
                                                    </td>
                                                    <td className="px-3 py-2">
                                                        {invoice.invoice_type}
                                                    </td>
                                                    <td className="px-3 py-2">
                                                        {invoice.doctor.length >
                                                        0 ? (
                                                            <div>
                                                                {invoice.doctor.map(
                                                                    (doc) => (
                                                                        <div
                                                                            key={
                                                                                doc.id
                                                                            }
                                                                        >
                                                                            Dr.{" "}
                                                                            {
                                                                                doc.name
                                                                            }{" "}
                                                                            (
                                                                            {
                                                                                doc.clinic
                                                                            }
                                                                            )
                                                                            <br />
                                                                            Number
                                                                            :{" "}
                                                                            {
                                                                                doc.daily_patient_index
                                                                            }
                                                                        </div>
                                                                    )
                                                                )}
                                                            </div>
                                                        ) : invoice.services
                                                              .length > 0 ? (
                                                            <div>
                                                                {invoice.services.map(
                                                                    (
                                                                        service
                                                                    ) => (
                                                                        <div className="mb-2"
                                                                            key={
                                                                                service.id
                                                                            }
                                                                        >
                                                                            {
                                                                                service.name
                                                                            }{" "}
                                                                            - $
                                                                            {
                                                                                service.price
                                                                            }
                                                                            <br />
                                                                            Number:{" "}
                                                                            {
                                                                                service.daily_patient_index
                                                                            }
                                                                            <hr className="w-24 py-1 border-gray-300 dark:border-gray-700"/>
                                                                        </div>

                                                                    )
                                                                )}
                                                            </div>
                                                        ) : (
                                                            <span>
                                                                No doctor or
                                                                service assigned
                                                            </span>
                                                        )}
                                                    </td>
                                                    <td className="px-3 py-2">
                                                        $
                                                        {invoice.total_with_tax}
                                                    </td>
                                                    <td className="px-3 py-2">
                                                        {invoice.created_at}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colSpan="5">
                                                        <hr className="my-2 border-gray-600" />
                                                    </td>
                                                </tr>
                                            </>
                                        ))}
                                    </tbody>
                                </table>
                            </div>

                            <Pagination links={invoices.meta.links} />
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
