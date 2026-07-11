import DashboardLayout from "@/Layouts/Dashboard/Layout";
import FormField from "@/BaseComponents/FormField";
import { useForm } from "@inertiajs/react";
import { useState, useEffect } from 'react'
import Button from "@/BaseComponents/Button";

import { toast } from 'react-toastify';

import Select from 'react-select';

import ModalReadCheque from "./Components/ModalReadCheque";
import ClientSearch from "./Components/ClientSearch";

function CreateCheque({ sendUrl, msg, banks, chequeType }) {

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
        is_registered: true,
        type: chequeType[0].value
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

    const addBank = (option) => {
        setData('bank', option.value);
    }

    const addOwner = (option) => {
        setData('owner', option.value);
    };

    return (
        <>
            <section>

                <div className="form-wrap">

                    {msg && (<div className='errors top'>{msg}</div>)}

                    <form action="" onSubmit={submitForm}>

                        <ClientSearch
                            childChanged={addOwner}
                            error={errors.owner}
                        />

                        <FormField
                            name="is_registered"
                            type="checkbox"
                            label="چک ثبت شده یا خیر"
                            value={data.is_registered}
                            onChange={addFormData}
                            error={errors.is_registered}
                            required
                        />

                        <FormField
                            name="price"
                            type="tel"
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
                        />

                        <FormField
                            name="sayadi_number"
                            type="tel"
                            label="شناسه صیادی (۱۶ رقمی)"
                            value={data.sayadi_number}
                            onChange={addFormData}
                            error={errors.sayadi_number}
                            required
                        />

                        <FormField
                            name="type"
                            type="select"
                            label="نوع چک(کاغذی یا دیجیتال)"
                            value={data.type}
                            onChange={addFormData}
                            error={errors.type}
                            options={chequeType}
                        />

                        <div className="form-group">
                            <Select
                                classNamePrefix="react-select"
                                defaultValue='انتخاب بانک'
                                isClearable={true}
                                isRtl={true}
                                isSearchable
                                name="bank"
                                options={banks}
                                placeholder=''
                                onChange={addBank}
                            />
                            <label htmlFor="exporter">بانک</label>
                            {errors.bank && <div className="errors">{errors.bank}</div>}
                        </div>

                        <FormField
                            name="account_number"
                            type="tel"
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

                        <Button isLoading={processing} />

                    </form>

                    <ModalReadCheque />

                </div>

            </section>
        </>
    )
}

CreateCheque.layout = page => <DashboardLayout children={page} h1="دریافت چک" />

export default CreateCheque;