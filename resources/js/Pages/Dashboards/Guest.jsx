import All from "@/Pages/Pizzas/All";
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import { useForm } from '@inertiajs/react';
import { Transition } from '@headlessui/react';
import InputError from "@/Components/InputError";
import SelectInputWithCombo from "@/Components/SelectInputWithCombo";

export default function GuestDashboard({ auth, pizzas, toppings }) {
    toppings = ["a","b"];

    let pizza = {
        size : "size",
        crust : "crush",
        toppings : " ",
    };
    
    const { data, patch, setData, processing, errors, recentlySuccessful } = useForm({
        size: pizza.size,
        crust: pizza.crust,
        toppings: pizza.toppings,
    });

    const submit = (e) => {
        //e.preventDefault();
        //patch(route('pizzas.update', pizza.id));
    };

    return (
        <>
            <AuthenticatedLayout
                user={auth.user}
                header={
                    <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                        Pizzas
                    </h2>
                }
            >
                <div className="py-12">
                    <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        </div>
                    </div>
                    <div className="p-5 max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        


                            <section className="max-w-xl p-10">
                                <header>
                                    <h2 className="text-lg font-medium text-gray-900">
                                        Order a Pizza
                                    </h2>

                                    <p className="mt-1 text-sm text-gray-600">
                                        
                                    </p>
                                </header>

                                <form onSubmit={submit} className="mt-6 space-y-6">
                                    <div>
                                        <InputLabel htmlFor="size" value="Size" />

                                        <TextInput
                                            id="size"
                                            className="mt-1 block w-full"
                                            value={data.size}
                                            onChange={(e) => setData('size', e.target.value)}
                                        />
                                    </div>

                                    <div>
                                        <InputLabel htmlFor="crust" value="Crust" />

                                        <TextInput
                                            id="crust"
                                            className="mt-1 block w-full"
                                            value={data.crust}
                                            onChange={(e) => setData('crust', e.target.value)}
                                        />
                                    </div>

                                    <div>
                                        <InputLabel htmlFor="toppings" value="toppings" />

                                        <SelectInputWithCombo
                                            id="role"
                                            className="mt-1 block w-full"
                                            options={toppings}
                                            //value={}
                                            //onChange={(e) => setData('role', e.target.value)}
                                            disabled
                                        />

                                        <InputError className="mt-2" message={errors.role} />
                                    </div>

                                    <div className="flex items-center gap-4">
                                        <PrimaryButton disabled={processing}>Send Order</PrimaryButton>

                                        <Transition
                                            show={recentlySuccessful}
                                            enter="transition ease-in-out"
                                            enterFrom="opacity-0"
                                            leave="transition ease-in-out"
                                            leaveTo="opacity-0"
                                        >
                                            <p className="text-sm text-gray-600">Sended</p>
                                        </Transition>
                                    </div>
                                </form>
                            </section>



                        </div>
                    </div>
                </div>
            </AuthenticatedLayout>
        </>
    );
}