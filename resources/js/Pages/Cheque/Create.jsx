import DashboardLayout from "@/Layouts/Dashboard/Layout";
import FormField from "@/BaseComponents/FormField";
import { useForm } from "@inertiajs/react";
import { useState, useEffect } from 'react'
import Button from "@/BaseComponents/Button";

import { toast } from 'react-toastify';

import Select from 'react-select';

import ModalReadCheque from "./Components/ModalReadCheque";
import ClientSearch from "./Components/ClientSearch";

function CreateCheque({ sendUrl, msg, banks, chequeType, cheque }) {

    const { data, setData, processing, post, put, reset, errors } = useForm({
        price: cheque?.price ?? '',
        sayadi_number: cheque?.sayadi_number ?? '',
        exporter: cheque?.exporter ?? '',
        account_number: cheque?.account_number ?? '',
        bank: cheque?.bank ?? '',
        img_url: null,
        due_date: cheque?.date_fa ?? '',
        status: 'pending',
        owner: cheque?.owner.id ?? '',
        is_registered: cheque?.is_registered ?? true,
        type: cheque?.type ?? chequeType[0].value
    });

    const selectedBank = banks.find(i => i.value == data.bank) || null;

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

        //Create new
        if (cheque == undefined) {
            post(sendUrl, {
                preserveScroll: true,
                onSuccess: () => {
                    reset();
                    toast.success(msg);
                }
            })

            //Update
        } else {
            put(sendUrl, {
                preserveScroll: true,
                onSuccess: () => {
                    toast.success(msg);
                }
            })
        }
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

                    <form action="" onSubmit={submitForm}>

                        <ClientSearch
                            childChanged={addOwner}
                            error={errors.owner}
                            value={{ value: cheque?.owner.id, label: cheque?.owner.name }}
                        />

                        <FormField
                            name="is_registered"
                            type="checkbox"
                            label="چک ثبت شده یا خیر"
                            value={data.is_registered}
                            onChange={addFormData}
                            error={errors.is_registered}
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
                                value={selectedBank}
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