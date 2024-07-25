import Pagination from "@/Components/Pagination";
import TextInput from "@/Components/TextInput";
import TableHeading from "@/Components/TableHeading";

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";

import { Head, Link, router } from "@inertiajs/react";

export default function Index({
    auth,
    invoices,
    queryParams = null,
    success,
}) {
    queryParams = queryParams || {};

    const searchFieldChanged = (name, value) => {
        if (value) {
            queryParams[name] = value;
        } else {
            delete queryParams[name];
        }
        if (name === "name") {
            delete queryParams.page;
        }

        router.get(route("invoice.index"), queryParams);
    };

    const onKeyPress = (name, event) => {
        if (event.key == "Enter") {
            searchFieldChanged(name, event.target.value);
        }
    };

    const sortChanged = (name) => {
        if (name === queryParams.sort_field) {
            if (queryParams.sort_direction === "asc") {
                queryParams.sort_direction = "desc";
            } else {
                queryParams.sort_direction = "asc";
            }
        } else {
            queryParams.sort_field = name;
            queryParams.sort_direction = "asc";
        }
        router.get(route("invoice.index"), queryParams);
    };

    const deleteInvoice = (invoice) => {
        if (!window.confirm("Are you sure you want to delete the invoices?")) {
            return;
        }

        router.delete(route("invoice.destroy", invoice.id));
    };
    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <div className="flex items-center justify-between">
                    <h2 className="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                        Invoices
                    </h2>
                    <Link
                        href={route("invoice.create")}
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
                    {success && (
                        <div className="px-4 py-2 mb-4 text-white rounded bg-emerald-500">
                            {success}
                        </div>
                    )}

                    <div className="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                        <div className="p-6 text-gray-900 dark:text-gray-100">
                            <div className="overflow-auto">
                                <table className="w-full text-sm text-left text-gray-500 rtl:text-right dark:text-gray-400">
                                    <thead className="text-xs text-gray-700 uppercase border-b-2 border-gray-500 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <tr className="text-nowrap">
                                            <TableHeading
                                                name="id"
                                                sort_field={
                                                    queryParams.sort_field
                                                }
                                                sort_direction={
                                                    queryParams.sort_direction
                                                }
                                                sortChanged={sortChanged}
                                            >
                                                Inoivce ID
                                            </TableHeading>
                                            <th className="px-3 py-3 min-w-[150px]">
                                                Patien ID
                                            </th>
                                            <TableHeading
                                                name="name"
                                                sort_field={
                                                    queryParams.sort_field
                                                }
                                                sort_direction={
                                                    queryParams.sort_direction
                                                }
                                                sortChanged={sortChanged}
                                            >
                                                Name
                                            </TableHeading>

                                            <th className="px-3 py-3 min-w-[150px]">
                                                Total With Tax
                                            </th>

                                            <TableHeading
                                                name="created_at"
                                                sort_field={
                                                    queryParams.sort_field
                                                }
                                                sort_direction={
                                                    queryParams.sort_direction
                                                }
                                                sortChanged={sortChanged}
                                            >
                                                Create Date
                                            </TableHeading>

                                            <th className="px-3 py-3 text-center">
                                                Actions
                                            </th>
                                        </tr>
                                    </thead>
                                    <thead className="text-xs text-gray-700 uppercase border-b-2 border-gray-500 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <tr className="text-nowrap">
                                            <th className="px-3 py-3"></th>
                                            <th className="px-3 py-3"></th>
                                            <th className="px-3 py-3">
                                                <TextInput
                                                    className="w-full min-w-[150px]"
                                                    placeholder="Patient Name"
                                                    onSubmit={(e) =>
                                                        searchFieldChanged(
                                                            "name",
                                                            e.target.value
                                                        )
                                                    }
                                                    onKeyPress={(e) =>
                                                        onKeyPress("name", e)
                                                    }
                                                ></TextInput>
                                            </th>
                                            <th className="px-3 py-3"></th>
                                            <th className="px-3 py-3"></th>
                                            <th className="px-3 py-3 text-right"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {invoices.data.map((invoice) => (
                                            <tr
                                                className="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                                                key={invoice.id}
                                            >
                                                <td className="px-3 py-2">
                                                    {invoice.id}
                                                </td>
                                                <td className="px-3 py-2">
                                                    #{invoice.patient_id}
                                                </td>
                                                <td className="px-3 py-2">
                                                    {invoice.name}
                                                </td>

                                                <td className="px-3 py-2 text-nowrap">
                                                    {invoice.total_with_tax}
                                                </td>
                                                <td className="px-3 py-2 text-nowrap">
                                                    {invoice.created_at}
                                                </td>

                                                <td className="px-3 py-2 text-center text-nowrap">
                                                    <Link
                                                        href={route(
                                                            "invoices.show",
                                                            invoice.id
                                                        )}
                                                        className="mx-1 font-medium text-blue-600 dark:text-blue-500 hover:underline"
                                                    >
                                                        Show
                                                    </Link>
                                                    <button
                                                        onClick={(e) =>
                                                            deleteInvoice(
                                                                invoice
                                                            )
                                                        }
                                                        className="mx-1 font-medium text-red-600 dark:text-red-500 hover:underline"
                                                    >
                                                        Delete
                                                    </button>
                                                </td>
                                            </tr>
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
