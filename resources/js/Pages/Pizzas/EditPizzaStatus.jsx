import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import { useForm } from '@inertiajs/react';
import { Transition } from '@headlessui/react';
import SelectInput from "@/Components/SelectInput.jsx";

export default function EditPizzaStatus({auth, pizza, statues, isChef}){

    const { data, setData, patch, errors, processing, recentlySuccessful } = useForm({
        status: pizza.status
    });

    const submit = (e) => {
        //e.preventDefault();
        //patch(route('pizzas.update', pizza.id));
    };

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Order #{pizza.id} </h2>}
        >
            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                    <div className="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <section className="max-w-xl">
                            <form onSubmit={submit} className="space-y-6">
                            <div>
                                {
                                    isChef?
                                    (<InputLabel htmlFor="status" value="Status Pizza" />):
                                    (<InputLabel htmlFor="status" value="Delivery Status" />)
                                }
                                

                                <SelectInput
                                    id="status"
                                    className="mt-1 block w-full"
                                    options={statues}
                                    value={data.status}
                                    onChange={(e) => setData('status', e.target.value)}/>

                                <InputError className="mt-2" message={errors.status} />
                            </div>

                            <div className="flex items-center gap-4">
                                <PrimaryButton disabled={processing}>Save</PrimaryButton>

                                <Transition
                                    show={recentlySuccessful}
                                    enter="transition ease-in-out"
                                    enterFrom="opacity-0"
                                    leave="transition ease-in-out"
                                    leaveTo="opacity-0">
                                    <p className="text-sm text-gray-600">Saved.</p>
                                </Transition>
                            </div>
                            </form>
                        </section>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    )
}