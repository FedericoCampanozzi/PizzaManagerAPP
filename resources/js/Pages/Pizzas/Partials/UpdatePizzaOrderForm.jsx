import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import { Link, useForm, usePage } from '@inertiajs/react';
import { Transition } from '@headlessui/react';
import SelectInput from "@/Components/SelectInput.jsx";
import PizzaStatus from './PizzaStatus';

export default function UpdatePizzaOrderForm({ pizza, statusOptions, toppings, className = '' }) {

    const { data, setData, patch, errors, processing, recentlySuccessful } = useForm({
        size: pizza.size,
        crust: pizza.crust,
        toppings: toppings,
        status: pizza.status
    });

    return (
        <section className={className}>
            <form className="space-y-6">
                <div>
                    <InputLabel htmlFor="size" value="Size" />

                    <TextInput
                        id="size"
                        className="mt-1 block w-full"
                        value={data.size}
                        disabled
                    />
                </div>

                <div>
                    <InputLabel htmlFor="crust" value="Crust" />

                    <TextInput
                        id="crust"
                        className="mt-1 block w-full"
                        value={data.crust}
                        disabled
                    />
                </div>

                <div>
                    <InputLabel htmlFor="toppings" value="Toppings" />

                    <TextInput
                        id="name"
                        className="mt-1 block w-full"
                        value={data.toppings}
                        disabled
                    />
                </div>

                <div>
                    <InputLabel htmlFor="status" value="Status" />

                    <SelectInput
                        id="status"
                        className="mt-1 block w-full"
                        options={statusOptions}
                        value={data.status}
                        disabled
                    />

                    <InputError className="mt-2" message={errors.status} />
                </div>

                <PizzaStatus currentStatus={pizza.status}></PizzaStatus>
                <div className="text-center mt-4">
                    <p className="text-lg">
                        {pizza.chef} follow your order 
                        <span className="underline font-semibold">{pizza.last_updated}</span>
                    </p>
                </div>

                <PizzaStatus currentStatus={pizza.status}></PizzaStatus>
                <div className="text-center mt-4">
                    <p className="text-lg">
                        {pizza.chef} take your pizza 
                        <span className="underline font-semibold">{pizza.last_updated}</span>
                    </p>
                </div>
            </form>
        </section>
    );
}
