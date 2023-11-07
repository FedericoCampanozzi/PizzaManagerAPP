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
} from 'chart.js';
import { Line } from 'react-chartjs-2';

ChartJS.register(
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  Title,
  Tooltip,
  Legend
);

const events = [{ title: "Meeting", start: new Date(2023,10,6), end: new Date(2023,10,9) }];

const get_options = (gfx_title) => {
    return {
        responsive: true,
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

const get_data = (labels, datasets) => {
    return {
      labels: ["a", "b", "c"],
      datasets: [
          {
            label: 'Cory Luettgen Sr.',
            data: [1,2,3],
            borderColor: 'rgb(53, 162, 235)',
            backgroundColor: 'rgba(53, 162, 235, 0.5)',
          },
          {
            label: 'Cory Luettgen Sr.',
            data: [4,12,13],
            borderColor: 'rgb(53, 162, 235)',
            backgroundColor: 'rgba(53, 162, 235, 0.5)',
          }]
    };
};

/* calendar callback */
const handleEventReceive = (eventInfo) => {
  const newEvent = {
    id: eventInfo.draggedEl.getAttribute("data-id"),
    title: eventInfo.draggedEl.getAttribute("title"),
    color: eventInfo.draggedEl.getAttribute("data-color"),
    start: eventInfo.date,
    end: eventInfo.date,
    custom: eventInfo.draggedEl.getAttribute("data-custom")
  };

  //console.log(eventInfo);
  /*
  setState((state) => {
    return {
      ...state,
      calendarEvents: state.calendarEvents.concat(newEvent)
    };
  });*/
};
/* **************** */



export default function AdminDashboard({
    auth,
    users,
    datasets_chef_weekly,
    gfx_chef_monthly,
    gfx_deliveryman_weekly,
    gfx_deliveryman_monthly
}) {
    const [activeView, setActiveView] = React.useState("timeGridDay");
    const calendarRef = React.useRef(null);

    React.useEffect(() => {
      //console.log("View Changed", activeView);
      const { current: calendarDom } = calendarRef;
      const API = calendarDom ? calendarDom.getApi() : null;
      API && API.changeView(activeView);
    }, [activeView]);
    //console.log(datasets_chef_weekly);
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
                            <div
                                className="p-5"
                                style={{
                                    //width: "50%",
                                    //float: "left",
                                    //height: "auto",
                                }}
                            >
                                <Line  options={get_options("Chef Weekly")} 
                                       data={get_data(datasets_chef_weekly)} />
                            </div>
                            <div
                                className="p-5"
                                style={{
                                    width: "50%",
                                    float: "right",
                                    height: "auto",
                                }}
                            >
                                
                            </div>
                            <div
                                className="p-5"
                                style={{
                                    width: "50%",
                                    float: "left",
                                    height: "auto",
                                }}
                            >
                                
                            </div>
                            <div
                                className="p-5"
                                style={{
                                    width: "50%",
                                    float: "right",
                                    height: "auto",
                                }}
                            >
                                
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
                                    initialView="dayGridMonth"
                                    editable={true}
                                    selectable={true}
                                    selectMirror={true}
                                    dayMaxEvents={true}
                                    weekends={true}
                                    events={events}
                                    droppable={true}
                                    eventReceive={handleEventReceive}
                                    locale={'it-IT'}
                                    eventDragStart={(e)=>console.log("event start",e)}
                                    eventDragStop={(e)=>console.log("event end",e)}
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </AuthenticatedLayout>
        </>
    );
}