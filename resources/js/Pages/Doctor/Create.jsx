import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import SelectInput from "@/Components/SelectInput";
import MultiSelectInput from "@/Components/MultiSelectInput";
import TextInput from "@/Components/TextInput";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link, useForm } from "@inertiajs/react";

export default function Create({ auth, specializations, clinics }) {
    const { data, setData, post, errors } = useForm({
        name: "",
        email: "",
        password: "",
        phone: "",
        address: "",
        specialization_id: "",
        clinic_id: "",
        price: "",
        days: [],
    });

    const onSubmit = (e) => {
        e.preventDefault();
        post(route("doctor.store"));
    };

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <div className="flex items-center justify-between">
                    <h2 className="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                        Create new doctor
                    </h2>
                </div>
            }
        >
            <Head title="Doctors" />

            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                        <form
                            onSubmit={onSubmit}
                            className="p-4 bg-white shadow sm:p-8 dark:bg-gray-800 sm:rounded-lg"
                        >
                            <div className="flex items-center justify-center text-xl font-medium text-gray-700 dark:text-gray-300">
                                <hr className="flex-1 my-6 border-gray-300 dark:border-gray-700" />
                                <span className="m-4">Doctor Info</span>
                                <hr className="flex-1 -my-6 border-gray-300 dark:border-gray-700" />
                            </div>

                            <div className="grid grid-cols-1 gap-4 p-10 md:grid-cols-2">
                                {/* Name */}
                                <div className="mt-4">
                                    <InputLabel htmlFor="name" value="Name" />
                                    <TextInput
                                        id="name"
                                        type="text"
                                        name="name"
                                        value={data.name}
                                        className="block w-full mt-1"
                                        onChange={(e) =>
                                            setData({
                                                ...data,
                                                name: e.target.value,
                                            })
                                        }
                                    />
                                    <InputError
                                        message={errors.name}
                                        className="mt-2"
                                    />
                                </div>

                                {/* Email */}
                                <div className="mt-4">
                                    <InputLabel htmlFor="email" value="Email" />
                                    <TextInput
                                        id="email"
                                        type="email"
                                        name="email"
                                        value={data.email}
                                        className="block w-full mt-1"
                                        onChange={(e) =>
                                            setData({
                                                ...data,
                                                email: e.target.value,
                                            })
                                        }
                                    />
                                    <InputError
                                        message={errors.email}
                                        className="mt-2"
                                    />
                                </div>

                                {/* Password */}
                                <div className="mt-4">
                                    <InputLabel
                                        htmlFor="password"
                                        value="Password"
                                    />
                                    <TextInput
                                        id="password"
                                        type="password"
                                        name="password"
                                        value={data.password}
                                        className="block w-full mt-1"
                                        onChange={(e) =>
                                            setData({
                                                ...data,
                                                password: e.target.value,
                                            })
                                        }
                                    />
                                    <InputError
                                        message={errors.password}
                                        className="mt-2"
                                    />
                                </div>

                                {/* Phone */}
                                <div className="mt-4">
                                    <InputLabel htmlFor="phone" value="Phone" />
                                    <TextInput
                                        id="phone"
                                        type="tel"
                                        name="phone"
                                        value={data.phone}
                                        className="block w-full mt-1"
                                        onChange={(e) =>
                                            setData({
                                                ...data,
                                                phone: e.target.value,
                                            })
                                        }
                                    />
                                    <InputError
                                        message={errors.phone}
                                        className="mt-2"
                                    />
                                </div>

                                {/* Address */}
                                <div className="mt-4">
                                    <InputLabel
                                        htmlFor="address"
                                        value="Address"
                                    />
                                    <TextInput
                                        id="address"
                                        type="text"
                                        name="address"
                                        value={data.address}
                                        className="block w-full mt-1"
                                        onChange={(e) =>
                                            setData({
                                                ...data,
                                                address: e.target.value,
                                            })
                                        }
                                    />
                                    <InputError
                                        message={errors.address}
                                        className="mt-2"
                                    />
                                </div>

                                <div className="mt-4">
                                    <InputLabel
                                        htmlFor="doctor_status"
                                        value="Classroom Status"
                                    />

                                    <SelectInput
                                        name="status"
                                        id="doctor_status"
                                        className="block w-full mt-1"
                                        onChange={(e) =>
                                            setData("status", e.target.value)
                                        }
                                    >
                                        <option value="">Select Status</option>
                                        <option value="active">active</option>
                                        <option value="inactive">
                                            inactive
                                        </option>
                                        <option value="retired">retired</option>
                                    </SelectInput>

                                    <InputError
                                        message={errors.status}
                                        className="mt-2"
                                    />
                                </div>
                            </div>

                            <div className="flex items-center justify-center text-xl font-medium text-gray-700 dark:text-gray-300">
                                <hr className="flex-1 my-6 border-gray-300 dark:border-gray-700" />
                                <span className="m-4">Specialization Info</span>
                                <hr className="flex-1 -my-6 border-gray-300 dark:border-gray-700" />
                            </div>

                            <div className="grid grid-cols-1 gap-4 p-10 md:grid-cols-4">
                                {/* Specialization */}
                                <div className="mt-4">
                                    <InputLabel
                                        htmlFor="specialization_id"
                                        value="Specialization Name"
                                    />
                                    <SelectInput
                                        name="specialization_id"
                                        className="block w-full mt-1"
                                        onChange={(e) =>
                                            setData({
                                                ...data,
                                                specialization_id:
                                                    e.target.value,
                                            })
                                        }
                                    >
                                        <option value="">
                                            Select specialization
                                        </option>
                                        {specializations.data.map(
                                            (specialization) => (
                                                <option
                                                    value={specialization.id}
                                                    key={specialization.id}
                                                >
                                                    {specialization.name}
                                                </option>
                                            )
                                        )}
                                    </SelectInput>
                                    <InputError
                                        message={errors.specialization_id}
                                        className="mt-2"
                                    />
                                </div>

                                {/* Clinic */}
                                <div className="mt-4">
                                    <InputLabel
                                        htmlFor="clinic_id"
                                        value="Clinic Name"
                                    />
                                    <SelectInput
                                        name="clinic_id"
                                        className="block w-full mt-1"
                                        onChange={(e) =>
                                            setData({
                                                ...data,
                                                clinic_id: e.target.value,
                                            })
                                        }
                                    >
                                        <option value="">Select clinic</option>
                                        {clinics.data.map((clinic) => (
                                            <option
                                                value={clinic.id}
                                                key={clinic.id}
                                            >
                                                {clinic.name}
                                            </option>
                                        ))}
                                    </SelectInput>
                                    <InputError
                                        message={errors.clinic_id}
                                        className="mt-2"
                                    />
                                </div>

                                {/* Session Price */}
                                <div className="mt-4">
                                    <InputLabel
                                        htmlFor="price"
                                        value="Session Price"
                                    />
                                    <TextInput
                                        id="price"
                                        type="number"
                                        name="price"
                                        value={data.price}
                                        className="block w-full mt-1"
                                        onChange={(e) =>
                                            setData({
                                                ...data,
                                                price: e.target.value,
                                            })
                                        }
                                    />
                                    <InputError
                                        message={errors.price}
                                        className="mt-2"
                                    />
                                </div>

                                {/* Days */}
                                <div className="mt-4">
                                    <InputLabel
                                        htmlFor="days"
                                        value="Available Days"
                                    />
                                    <MultiSelectInput
                                        name="days"
                                        className="block w-full mt-1"
                                        onChange={(e) =>
                                            setData({
                                                ...data,
                                                days: Array.from(
                                                    e.target.selectedOptions,
                                                    (option) => option.value
                                                ),
                                            })
                                        }
                                    >
                                        {[
                                            "Sunday",
                                            "Monday",
                                            "Tuesday",
                                            "Wednesday",
                                            "Thursday",
                                            "Friday",
                                            "Saturday",
                                        ].map((day) => (
                                            <option key={day} value={day}>
                                                {day}
                                            </option>
                                        ))}
                                    </MultiSelectInput>
                                    <InputError
                                        message={errors.days}
                                        className="mt-2"
                                    />
                                </div>
                            </div>

                            <div className="mt-4 text-right">
                                <Link
                                    href={route("doctor.index")}
                                    className="px-3 py-1 mr-2 text-gray-800 transition-all bg-gray-100 rounded shadow hover:bg-gray-200"
                                >
                                    Cancel
                                </Link>
                                <button
                                    type="submit"
                                    className="px-3 py-1 text-white transition-all rounded shadow bg-emerald-500 hover:bg-emerald-600"
                                >
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
