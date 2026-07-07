import Button               from '@/BaseComponents/Button';
import BackButton           from '@/BaseComponents/BackButton';
import FullPageFormLayout   from "@/Layouts/FullPage/Layout";

import { useState, useEffect }  from 'react';
import { FcCancel }             from "react-icons/fc";
import { Link, router }         from '@inertiajs/react'


const LoginForm = ({ errors, sendUrl, registerUrl, otpLoginUrl }) => {

    //Active first input
    useEffect(() => {
        document.querySelector('input:first-child').focus();
    }, []);

    const [isLoading, setIsLoading] = useState(false);
    const [valid, setValid] = useState({
        number: '',
        password: ''
    });
    const [values, setValues] = useState({
        number: "",
        password: "",
    });


    function handleChange(e) {
        const key = e.target.id;
        const value = e.target.value;

        setValid((prevValid) => {
            let newValidate = { ...prevValid }

            switch (key) {
                case "number":
                    newValidate.number = validNumber(value);
                    break;
                case "password":
                    newValidate.password = validPassword(value);
                    break;
            }

            return newValidate;
        })

        setValues(values => ({
            ...values,
            [key]: value,
        }))
    }

    function validNumber(val) {
        return (val.length > 11) ? 'شماره باید 11 رقم باشد' : '';
    }

    function validPassword(val) {
        return true;
    }

    function handleSubmit(e) {
        e.preventDefault();

        router.post(sendUrl, values, {
            onStart: () => setIsLoading(true),
            onFinish: () => setIsLoading(false),
            onError: (errors) => {
                //console.error('Login error:', errors);
            }
        });

    }

    return (
        <>
            <div className="form-head">
                <BackButton />
                <p className='form-title'>
                    ورود
                </p>
            </div>


            {errors.number &&
                <div className="errors top">
                    <FcCancel />
                    {errors.number}
                </div>
            }

            <form action="#" onSubmit={handleSubmit}>

                <div className={`form-group ${valid.number === '' ? '' : 'not-valid'}`}>
                    <input type="tel" required value={values.number} onChange={handleChange} id="number" placeholder='' maxLength="11" />
                    <label htmlFor='number'>
                        نام کاربری
                    </label>
                </div>

                <div className="form-group">
                    <input type="password" required value={values.password} onChange={handleChange} id="password" placeholder='' />
                    <label htmlFor='password'>
                        رمز عبور
                    </label>
                </div>

                <Button isLoading={isLoading} text='ورود' />
            </form>

            <div className='button-link'>
                <div className="or-line flex">
                    <span className='line'></span>
                    <small>یا</small>
                    <span className='line'></span>
                </div>

                <div className='links flex'>
                    <Link href={registerUrl}>
                        ثبت نام
                    </Link>

                    <Link href={otpLoginUrl}>
                        ورود با کد یکبار مصرف
                    </Link>
                </div>

            </div>
        </>
    )
};


LoginForm.layout = page => <FullPageFormLayout children={page} />

export default LoginForm;