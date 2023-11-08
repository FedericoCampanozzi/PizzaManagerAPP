import React from "react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import Table from "@/Components/Table.jsx";
import FullCalendar from "@fullcalendar/react";
import dayGridPlugin from "@fullcalendar/daygrid";
import interactionPlugin from "@fullcalendar/interaction";
import timeGridPlugin from "@fullcalendar/timegrid";
import {
  Chart as ChartJS,
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  Title,
  Tooltip,
  Legend,
  BarElement
} from 'chart.js';
import { Line, Bar } from 'react-chartjs-2';

ChartJS.register(
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  Title,
  Tooltip,
  Legend,
  BarElement
);

const get_options = (gfx_title, xLabel = 'x', yLabel = 'y') => {
    return {
        responsive: true,
        scales:{
            y:{
                title: {
                    display: true,
                    text: yLabel
                }
            },
            x:{
                title: {
                    display: true,
                    text: xLabel
                }
            }
        },
        plugins: {
            legend: {
                position: "top",
            },
            title: {
                display: true,
                text: gfx_title,
            },
        },
    };
};

const get_data = (lbls, dts) => {
    return {
      labels: lbls,
      datasets: dts
    };
};

export default function AdminDashboard({
    auth,
    users,
    chef_weekly_data,
    chef_weekly_labels,
    chef_monthly_data,
    chef_monthly_labels,
    chef_monthly_data_stack,
    chef_monthly_labels_stack,
    holidays
}) {    
    const [activeView, setActiveView] = React.useState("timeGridDay");
    const calendarRef = React.useRef(null);

    React.useEffect(() => {
      const { current: calendarDom } = calendarRef;
      const API = calendarDom ? calendarDom.getApi() : null;
      API && API.changeView(activeView);
    }, [activeView]);

    return (
        <>
            <AuthenticatedLayout
                user={auth.user}
                header={
                    <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                        Administrator
                    </h2>
                }
            >
                <div className="py-12">
                    <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <Table
                                items={users}
                                primary="User ID"
                                columns={["name", "email", "userole"]}
                                action="editrole"
                                actionlabel="Edit Role"
                            />
                        </div>
                    </div>
                </div>

                <div className="py-12">
                    <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div className="p-5">
                                <Line  options={get_options("Chef Weekly", "Weeks", "Pizzas")} 
                                       data={get_data(chef_weekly_labels, chef_weekly_data)} />
                            </div>
                            <div className="p-5">
                                <Bar   options={get_options("Chef Monthy", "Month", "Pizzas")} 
                                       data={get_data(chef_monthly_labels, chef_monthly_data)} />
                            </div>
                            <div className="p-5">
                                <Bar   options={get_options("Chef Monthy Stacked", "Month", "Pizzas")} 
                                       data={get_data(chef_monthly_labels_stack, chef_monthly_data_stack)} />
                            </div>
                        </div>
                    </div>
                </div>

                <div className="py-12">
                    <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div className="p-10">
                                <FullCalendar
                                    plugins={[dayGridPlugin, timeGridPlugin, interactionPlugin]}
                                    headerToolbar={{
                                      left: "prev,next today",
                                      center: "title",
                                      right: "dayGridMonth,timeGridWeek,timeGridDay"
                                    }}
                                    events={holidays}
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </AuthenticatedLayout>
        </>
    );
}