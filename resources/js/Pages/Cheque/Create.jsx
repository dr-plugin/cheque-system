import DashboardLayout from "@/Layouts/Dashboard/Layout";
import FormField from "@/BaseComponents/FormField";
import { useForm } from "@inertiajs/react";
import { useState, useEffect } from 'react'
import Button from "@/BaseComponents/Button";

import { toast } from 'react-toastify';

function CreateCheque({ sendUrl, msg, clients, banks, chequeStatuses }) {

    const { data, setData, processing, post, reset, errors } = useForm({
        price: '',
        sayadi_number: '',
        exporter: '',
        account_number: '',
        bank: '',
        img_url: null,
        due_date: '',
        status: 'pending',
        owner: '',
    });


    function addFormData(e) {
        const { id, type, value, checked } = e.target;

        setData((prevData) => {
            let val = type === 'checkbox' ? checked : value;
            return {
                ...prevData,
                [id]: val
            }
        });
    }

    function submitForm(e) {

        e.preventDefault();

        post(sendUrl, {
            preserveScroll: true,
            onSuccess: () => {
                reset();
                toast.success("عملیات با موفقیت انجام شد!");
            }
        })
    }

    return (
        <>
            <section>

                <div className="form-wrap">

                    {msg && (<div className='errors top'>{msg}</div>)}

                    <form action="" onSubmit={submitForm}>

                        <FormField
                            name="owner"
                            type="select"
                            label="مالک چک"
                            value={data.owner}
                            onChange={addFormData}
                            error={errors.owner}
                            options={clients} 
                            required
                        />

                        <FormField
                            name="price"
                            type="number"
                            label="مبلغ چک (ریال)"
                            value={data.price}
                            onChange={addFormData}
                            error={errors.price}
                            required
                        />

                        <FormField
                            name="exporter"
                            label="صادرکننده چک"
                            value={data.exporter}
                            onChange={addFormData}
                            error={errors.exporter}
                            required
                        />

                        <FormField
                            name="sayadi_number"
                            label="شناسه صیادی (۱۶ رقمی)"
                            value={data.sayadi_number}
                            onChange={addFormData}
                            error={errors.sayadi_number}
                        />

                        <FormField
                            name="bank"
                            type="select"
                            label="بانک صادرکننده"
                            value={data.bank}
                            onChange={addFormData}
                            error={errors.bank}
                            options={banks}
                            required
                        />

                        <FormField
                            name="account_number"
                            label="شماره حساب"
                            value={data.account_number}
                            onChange={addFormData}
                            error={errors.account_number}
                        />

                        <FormField
                            name="due_date"
                            type="text"
                            label="تاریخ سررسید (مثال: 1405/04/17)"
                            value={data.due_date}
                            onChange={addFormData}
                            error={errors.due_date}
                        />

                        <FormField
                            name="status"
                            type="select"
                            label="وضعیت چک"
                            value={data.status}
                            onChange={addFormData}
                            error={errors.status}
                            options={chequeStatuses}
                            required
                        />

                        <Button isLoading={processing} />

                    </form>

                </div>

            </section>
        </>
    )
}

CreateCheque.layout = page => <DashboardLayout children={page} h1="دریافت چک" />

export default CreateCheque;