import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import ShowStatus from './Partials/ShowStatus';
import InputLabel from '@/Components/InputLabel';
import TextInput from '@/Components/TextInput';

export default function ShowOrderDetail({ auth, pizza, pizzastatues, deliverystatues, toppings }) {
    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Order #{pizza.id}</h2>}
        >
            <Head title={'Order #' + pizza.id} />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                    <div className="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <section className="max-w-xl">
                            <form className="space-y-6">
                                <div>
                                    <InputLabel htmlFor="size" value="Size" />

                                    <TextInput
                                        id="size"
                                        className="mt-1 block w-full"
                                        value={pizza.size}
                                        disabled
                                    />
                                </div>

                                <div>
                                    <InputLabel htmlFor="crust" value="Crust" />

                                    <TextInput
                                        id="crust"
                                        className="mt-1 block w-full"
                                        value={pizza.crust}
                                        disabled
                                    />
                                </div>

                                <div>
                                    <InputLabel htmlFor="toppings" value="Toppings" />

                                    <TextInput
                                        id="name"
                                        className="mt-1 block w-full"
                                        value={toppings}
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
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
