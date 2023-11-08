import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import { useForm } from '@inertiajs/react';
import { Transition } from '@headlessui/react';
import ComboSelect from 'react-combo-select';
import Table from '@/Components/Table';

const selectOptions = { scrollHeight: 200, direction: 'down' }

export default function GuestDashboard({ auth, pizzas, all_toppings, new_pizza}) {

    console.log(all_toppings);

    const { data, patch, setData, processing, errors, recentlySuccessful } = useForm({
        size: new_pizza.size,
        crust: new_pizza.crust,
        toppings: new_pizza.toppings,
    });

    const submit = (e) => {
        e.preventDefault();
        console.log(new_pizza);
        patch(route('pizzas.insert', pizza.id));
    };

    const addToppingToPizza = (value, text) => {
        if(value){
            new_pizza.toppings = text;
        }
    }

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
                            <Table  items={pizzas} 
                                    columns={[
                                        'client',
                                        'size',
                                        'aaaa',
                                        'status',
                                        'chef',
                                        'deliveryman',
                                        'delivery'
                                    ]} 
                                    primary="Order Number" 
                                    action="pizzas.showorderdetail"
                                    noResultLabel="You didn't order any pizzas"
                                    fixedHeader='true' />                                    
                        </div>
                    </div>
                    <div className="p-5 max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        


                            <section className="max-w-xl p-10 pb-100">
                                <header>
                                    <h2 className="text-lg font-medium text-gray-900">
                                        Order a Pizza
                                    </h2>
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

                                        <ComboSelect    data={all_toppings} 
                                                        text="No toppings :("
                                                        onChange={addToppingToPizza}
                                                        type="multiselect"
                                                        {...selectOptions}/>
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