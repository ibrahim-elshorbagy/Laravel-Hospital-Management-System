// ServiceInvoice.js
import InputLabel from "@/Components/InputLabel";
import SelectInput from "@/Components/SelectInput";
import InputError from "@/Components/InputError";

export default function ServiceInvoice({ services, setData, errors }) {
    return (
        <div className="mt-4">
            <InputLabel htmlFor="service" value="Select Service" />
            <SelectInput
                name="service"
                id="service"
                className="w-full h-64 mt-1 border-gray-300 rounded-md shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50"
                multiple
                onChange={(e) => {
                    const selectedServices = [...e.target.selectedOptions].map(
                        (option) => {
                            const service = services.find(
                                (service) =>
                                    service.id === parseInt(option.value)
                            );
                            return service
                                ? {
                                      id: service.id,
                                      name: service.name,
                                      price: service.price,
                                  }
                                : {};
                        }
                    );
                    setData("selectedServices", selectedServices);
                }}
            >
                {services.map((service) => (
                    <option key={service.id} value={service.id}>
                        {service.name} (${parseFloat(service.price).toFixed(2)})
                    </option>
                ))}
            </SelectInput>
            <InputError message={errors.selectedServices} className="mt-2" />
        </div>
    );
}
