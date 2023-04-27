import "./styles.css";

import React, { useState, useEffect } from "react";

import { LineChart, Line, XAxis, YAxis, CartesianGrid, Tooltip, Legend, ResponsiveContainer } from 'recharts';

export default function App() {
    const [ data, setData ] = useState();

    // Set 7 days as the default number of days
    useEffect(() => {
        fetchData(7);
    }, []);

    // Fetch the graph data using WordPress rest api.
    const fetchData = async (number) => {
        const response = await fetch(`/wp-json/dashboard-widget/v1/data/${number}`);
        const data = await response.json();
        setData(data);
    }

    //On select number of days, fetch data
    const selectDays = (event) => {
        const number = event.target.value;
        fetchData(number);
    }
    return(
        <div>
            <div id="graph-header">
                <h4>Graph Widget</h4>
                <select onChange={selectDays}>
                    <option value="7">Last 7 Days</option>
                    <option value="15">Last 15 Days</option>
                    <option value="30">Last 1 Month</option>
                </select>
            </div>
            <div id="graph-body">
                <LineChart width={500} height={300} data={data}>
                    <XAxis dataKey="name"/>
                    <YAxis/>
                    <CartesianGrid stroke="#eee" strokeDasharray="5 5"/>
                    <Line type="monotone" dataKey="uv" stroke="#8884d8" />
                    <Line type="monotone" dataKey="pv" stroke="#82ca9d" />
                </LineChart>
            </div>
        </div>
    );
}