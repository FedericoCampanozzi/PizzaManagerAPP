import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import { useForm } from '@inertiajs/react';
import { Transition } from '@headlessui/react';
import Table from '@/Components/Table';
import Select from "react-dropdown-select";
import styled from "@emotion/styled";

let sel_toppings = [];
let search_value = "";

const columns = [
    {name : 'Client', value : 'client'},
    {name : 'Chef', value : 'aaa'},
    {name : 'Status', value : 'status'},
    {name : 'Delivery Man', value : 'deliveryman'},
    {name : 'Delivery Status', value : 'delivery'}
];

const itemRenderer = ({ item, props, methods }) => (
<div key={item[props.valueField]} onClick={() => methods.addItem(item)}>
    <div style={{ margin: "10px" }}>
    <input type="checkbox" checked={methods.isSelected(item)} onChange={e=>{}} />
    &nbsp;&nbsp;&nbsp;{item[props.labelField]}
    </div>
</div>
);

const SearchAndToggle = styled.div`
  display: flex;
  flex-direction: column;

  input {
    margin: 10px 10px 0;
    line-height: 30px;
    padding: 0 20px;
    border: 1px solid #ccc;
    border-radius: 3px;
    :focus {
      outline: none;
      border: 1px solid ${({ color }) => color};
    }
  }
`;
const Items = styled.div`
  overflow: auto;
  min-height: 10px;
  max-height: 200px;
`;

const Item = styled.div`
  display: flex;
  margin: 10px;
  align-items: baseline;
  cursor: pointer;
  border-bottom: 1px dotted transparent;

  :hover {
    border-bottom: 1px dotted #ccc;
  }

  ${({ disabled }) =>
    disabled
      ? `
  	opacity: 0.5;
  	pointer-events: none;
  	cursor: not-allowed;
  `
      : ""}
`;

const ItemLabel = styled.div`
  margin: 5px 10px;
`;

const Buttons = styled.div`
  display: flex;
  justify-content: space-between;

  & div {
    margin: 10px 0 0 10px;
    font-weight: 600;
  }
`;

const Button = styled.button`
  background: none;
  border: 1px solid #555;
  color: #555;
  border-radius: 3px;
  margin: 10px 10px 0;
  padding: 3px 5px;
  font-size: 10px;
  text-transform: uppercase;
  cursor: pointer;
  outline: none;

  &.clear {
    color: tomato;
    border: 1px solid tomato;
  }

  :hover {
    border: 1px solid deepskyblue;
    color: deepskyblue;
  }
`;

const dropdownRenderer = ({ props, methods }) => {
    const fake_state_color = '#80bfff';
    const fake_state_keepSelectedInList = true;



    const regexp = new RegExp(search_value, "i");

    return (
      <div>
        <SearchAndToggle color={fake_state_color}>
          <Buttons>
            <div>Search and select:</div>
            {methods.areAllSelected() ? (
              <Button className="clear" onClick={methods.clearAll}>
                Clear all
              </Button>
            ) : (
              <Button onClick={methods.selectAll}>Select all</Button>
            )}
          </Buttons>
          <input
            type="text"
            value={search_value}
            onChange={methods.setSearch}
            placeholder="Type anything"
          />
        </SearchAndToggle>
        <Items>
          {props.options
            .filter(item =>
              regexp.test(item[props.searchBy] || item[props.labelField])
            )
            .map(option => {
              if (
                !fake_state_keepSelectedInList &&
                methods.isSelected(option)
              ) {
                return null;
              }

              return (
                <Item
                  disabled={option.disabled}
                  key={option[props.valueField]}
                  onClick={
                    option.disabled ? null : () => methods.addItem(option)
                  }
                >
                  <input
                    type="checkbox"
                    onChange={() => methods.addItem(option)}
                    checked={sel_toppings.indexOf(option) !== -1}
                  />
                  <ItemLabel>{option[props.labelField]}</ItemLabel>
                </Item>
              );
            })}
        </Items>
      </div>
    );
};

export default function GuestDashboard({    auth, 
                                            pizzas, 
                                            all_toppings, 
                                            all_sizes, 
                                            all_crusts, 
                                            new_pizza
                                        }) {
    /*
    console.log("pizzas=",pizzas);
    console.log("all_toppings=",all_toppings);
    console.log("all_sizes=",all_sizes);
    console.log("all_crusts=",all_crusts);
    */

    const { patch, processing, recentlySuccessful } = useForm({
        size: new_pizza.size,
        crust: new_pizza.crust,
        toppings: sel_toppings,
    });

    const submit = (e) => {
        e.preventDefault();
        console.log("insert = ", new_pizza, " and ", sel_toppings);
        //patch(route('pizzas.insert', pizza.id));
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
                                    columns={columns} 
                                    primary="Order Number" 
                                    action="pizzas.showorderdetail"
                                    noResultLabel="You didn't order any pizzas"
                                    fixedHeader='true' />                                    
                        </div>
                    </div>
                    <div className="p-5 max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <section className="max-w-xl p-10 py-90">
                                <header>
                                    <h2 className="text-lg font-medium text-gray-900">
                                        Order a Pizza
                                    </h2>
                                </header>

                                <form onSubmit={submit} className="mt-6 space-y-6">
                                    <div>
                                        <InputLabel htmlFor="toppings" value="Toppings" />
                                        <Select options={all_toppings} 
                                                labelField="name" 
                                                valueField="id"
                                                multi="true"
                                                itemRenderer={itemRenderer}
                                                dropdownRenderer={dropdownRenderer}

                                                onChange={(values) => sel_toppings = values} />
                                    </div>
                                    
                                    <div>
                                        <InputLabel htmlFor="size" value="Size" />
                                        <Select options={all_sizes} 
                                                labelField="sid" 
                                                valueField="sid"
                                                itemRenderer={itemRenderer}

                                                onChange={(values) => new_pizza.size = values[0]["sid"] } />
                                    </div>

                                    <div>
                                        <InputLabel htmlFor="crust" value="Crust" />
                                        <Select options={all_crusts} 
                                                labelField="sid" 
                                                valueField="sid"
                                                itemRenderer={itemRenderer}

                                                onChange={(values) => new_pizza.crust = values[0]["sid"]} />
                                    </div>

                                    <div className="flex items-center gap-4 div-on-bot">
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