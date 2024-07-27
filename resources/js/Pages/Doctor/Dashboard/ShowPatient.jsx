import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import TextInput from "@/Components/TextInput";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link, useForm } from "@inertiajs/react";
import { Tab, TabGroup, TabList, TabPanels, TabPanel } from "@headlessui/react";
import {
    VerticalTimeline,
    VerticalTimelineElement,
} from "react-vertical-timeline-component";
import "react-vertical-timeline-component/style.min.css";
import TextAreaInput from "@/Components/TextAreaInput";

function classNames(...classes) {
    return classes.filter(Boolean).join(" ");
}

export default function PatientDiagnostics({
    auth,
    patient,
    diagnostics,
    invoice_id,
}) {
    const { data, setData, post, errors } = useForm({
        diagnosis: "",
        medicine: "",
        invoice_id: invoice_id || "",
        patient_id: patient.id || "",
    });

    const onSubmit = (e) => {
        e.preventDefault();
        post(route("doc.patient.diagnosis"));
    };

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <div className="flex items-center justify-between">
                    <h2 className="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                        Patient Diagnostics
                    </h2>
                </div>
            }
        >
            <Head title="Patient Diagnostics" />

            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                        <TabGroup>
                            <TabList className="flex p-1 space-x-1 bg-gray-200 rounded-lg dark:bg-gray-700">
                                <Tab
                                    className={({ selected }) =>
                                        classNames(
                                            "w-full py-2.5 text-sm leading-5 font-medium rounded-lg",
                                            selected
                                                ? "bg-white dark:bg-gray-800 shadow text-blue-700"
                                                : "text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600"
                                        )
                                    }
                                >
                                    Enter Diagnostics
                                </Tab>
                                <Tab
                                    className={({ selected }) =>
                                        classNames(
                                            "w-full py-2.5 text-sm leading-5 font-medium rounded-lg",
                                            selected
                                                ? "bg-white dark:bg-gray-800 shadow text-blue-700"
                                                : "text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600"
                                        )
                                    }
                                >
                                    Patient History
                                </Tab>
                            </TabList>
                            <TabPanels className="mt-4">
                                <TabPanel className="p-4 bg-white shadow sm:p-8 dark:bg-gray-800 sm:rounded-lg">
                                    <form onSubmit={onSubmit}>
                                        <TextInput
                                            id="invoice_id"
                                            type="hidden"
                                            name="invoice_id"
                                            value={data.invoice_id}
                                        />
                                        <TextInput
                                            id="patient_id"
                                            type="hidden"
                                            name="patient_id"
                                            value={data.patient_id}
                                        />
                                        <div className="mb-4">
                                            <InputLabel
                                                htmlFor="diagnosis"
                                                value="Diagnosis"
                                            />
                                            <TextAreaInput
                                                id="diagnosis"
                                                name="diagnosis"
                                                value={data.diagnosis}
                                                className="block w-full mt-1 dark:bg-gray-700 dark:text-white min-h-40"
                                                onChange={(e) =>
                                                    setData(
                                                        "diagnosis",
                                                        e.target.value
                                                    )
                                                }
                                            />
                                            <InputError
                                                message={errors.diagnosis}
                                                className="mt-2"
                                            />
                                        </div>

                                        <div className="mb-4">
                                            <InputLabel
                                                htmlFor="medicine"
                                                value="Medicine"
                                            />
                                            <TextAreaInput
                                                id="medicine"
                                                name="medicine"
                                                value={data.medicine}
                                                className="block w-full mt-1 dark:bg-gray-700 dark:text-white min-h-52"
                                                onChange={(e) =>
                                                    setData(
                                                        "medicine",
                                                        e.target.value
                                                    )
                                                }
                                            />
                                            <InputError
                                                message={errors.medicine}
                                                className="mt-2"
                                            />
                                        </div>

                                        <div className="text-right">
                                            <button
                                                type="submit"
                                                className="px-4 py-2 font-semibold text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                                            >
                                                Submit
                                            </button>
                                        </div>
                                    </form>
                                </TabPanel>
                                <TabPanel className="p-4 bg-white shadow sm:p-8 dark:bg-gray-800 sm:rounded-lg">
                                    <div className="mb-4 text-xl font-medium text-gray-700 dark:text-gray-300">
                                        Patient History
                                    </div>
                                    {diagnostics.length === 0 ? (
                                        <p className="text-gray-500 dark:text-gray-400">
                                            No diagnostics available.
                                        </p>
                                    ) : (
                                        <VerticalTimeline>
                                            {diagnostics.map(
                                                (diagnostic, index) => (
                                                    <VerticalTimelineElement
                                                        key={index}
                                                        className="vertical-timeline-element--work"
                                                        contentStyle={{
                                                            background:
                                                                "rgb(33, 150, 243)",
                                                            color: "#fff",
                                                        }}
                                                        contentArrowStyle={{
                                                            borderRight:
                                                                "7px solid rgb(33, 150, 243)",
                                                        }}
                                                        date={`${new Date(
                                                            diagnostic.created_at
                                                        ).toLocaleDateString(
                                                            "en-CA"
                                                        )} - Dr: ${
                                                            diagnostic.doctor
                                                                .user.name
                                                        }, ${
                                                            diagnostic.doctor
                                                                .clinic.name
                                                        }`}
                                                        iconStyle={{
                                                            background:
                                                                "rgb(33, 150, 243)",
                                                            color: "#fff",
                                                        }}
                                                    >
                                                        <h3 className="vertical-timeline-element-title">
                                                            Diagnosis{" "}
                                                            {index + 1}
                                                        </h3>
                                                        <div className="flex justify-between">
                                                            <div>
                                                                <p>
                                                                    <strong>
                                                                        Diagnosis:
                                                                    </strong>{" "}
                                                                    {
                                                                        diagnostic.diagnosis
                                                                    }
                                                                </p>
                                                                <p>
                                                                    <strong>
                                                                        Medicine:
                                                                    </strong>{" "}
                                                                    {
                                                                        diagnostic.medicine
                                                                    }
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </VerticalTimelineElement>
                                                )
                                            )}
                                        </VerticalTimeline>
                                    )}
                                </TabPanel>
                            </TabPanels>
                        </TabGroup>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
