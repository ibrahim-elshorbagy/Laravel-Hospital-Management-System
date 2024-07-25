// PackageInvoice.js
import InputLabel from "@/Components/InputLabel";
import SelectInput from "@/Components/SelectInput";
import InputError from "@/Components/InputError";

export default function PackageInvoice({ packages, setData, errors }) {
    return (
        <div className="mt-4">

            <InputLabel htmlFor="package" value="Select Package" />
            <SelectInput
                name="package"
                id="package"
                className="w-full h-64 mt-1 border-gray-300 rounded-md shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50"
                multiple
                onChange={(e) => {
                    const selectedPackages = [...e.target.selectedOptions].map(
                        (option) => {
                            const pkg = packages.find(
                                (pkg) => pkg.id === parseInt(option.value)
                            );
                            return pkg
                                ? {
                                      id: pkg.id,
                                      name: pkg.name,
                                      price: pkg.Total_with_tax,
                                  }
                                : {};
                        }
                    );
                    setData("selectedPackages", selectedPackages);
                }}
            >
                {packages.map((pkg) => (
                    <option key={pkg.id} value={pkg.id}>
                        {pkg.name} (${parseFloat(pkg.Total_with_tax).toFixed(2)}
                        )
                    </option>
                ))}
            </SelectInput>
            <InputError message={errors.selectedPackages} className="mt-2" />
        </div>
    );
}
