import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import PrimaryButton from '@/Components/PrimaryButton';
import { useForm } from '@inertiajs/react';
import { Transition } from '@headlessui/react';

export default function EditPizzaStatus({auth, pizza, next_status, isChef}){

    const { patch, processing, recentlySuccessful } = useForm({});

    const submit = (e) => {
        e.preventDefault();
        patch(route('pizza.update', [pizza, next_status, auth.user, isChef]));
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
                                <strong>Current Pizza Info</strong> <br /><br />
                                Chef : {pizza.chef} <br />
                                Pizza Status : {pizza.status} <br />
                                
                                { 
                                    pizza.fk_pizzastatus != 3 ? 
                                    (<>
                                        <span>Pizza is not ready so there mustn't have delivery-man</span>
                                        <br />
                                    </>):(
                                        <></>
                                    )
                                }

                                {
                                    pizza.fk_pizzastatus == 3 && pizza.deliveryman == null ? 
                                    (
                                        <>
                                            <span>This pizza isn't taking by any riderds</span><br />
                                        </>
                                        ):(
                                            <></>
                                        )
                                }

                                { 
                                    pizza.fk_pizzastatus == 3 && pizza.deliveryman != null ? 
                                    (
                                        <>
                                            <span>Delivery status : {pizza.delivery}</span><br />
                                            <span>Delivery Man : {pizza.deliveryman}</span>
                                        </>
                                    ):(
                                        <>
                                        </>
                                    )
                                }

                                {
                                    next_status == null ? (
                                        <>
                                            <br /><br />
                                            <span><strong>Final status reached</strong></span>
                                        </>
                                    ) : (
                                        <>
                                            <div className='py-5'>
                                                Change status in <strong>{next_status.name}</strong>
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
                                        </>
                                    )
                                }

                            </form>
                        </section>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    )
}