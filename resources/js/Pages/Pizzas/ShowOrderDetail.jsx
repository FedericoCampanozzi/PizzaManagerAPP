import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import TextInput from '@/Components/TextInput';
import { useForm } from '@inertiajs/react';
import SelectInput from "@/Components/SelectInput.jsx";
import ShowStatus from "@/Pages/Pizzas/Partials/ShowStatus.jsx";

export default function ShowOrderDetail({ pizza, pizzastatues, deliverystatues, toppings, className = '' }) {
    const { data } = useForm({
        size: pizza.size,
        crust: pizza.crust,
        toppings: toppings,
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

                <ShowStatus statuses={pizzastatues} 
                            currentStatus={pizza.status}
                            currentMan={pizza.chef}
                            isPizzaStatus={true} />
                <ShowStatus statuses={deliverystatues}
                            currentStatus={pizza.delivery}
                            currentMan={pizza.deliveryman}
                            isPizzaStatus={false} />
            </form>
        </section>
    );
}
