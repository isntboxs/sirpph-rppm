import { createFileRoute, useNavigate } from '@tanstack/react-router'
import { useForm } from '@tanstack/react-form'

import { IconAt, IconEye, IconEyeOff, IconLock } from '@tabler/icons-react'
import { useState } from 'react'
import { toast } from 'sonner'
import {
  Card,
  CardContent,
  CardDescription,
  CardHeader,
  CardTitle,
} from '#/components/ui/card'
import { signInRequestSchema } from '#/schemas/auth.schema'
import {
  Field,
  FieldError,
  FieldGroup,
  FieldLabel,
} from '#/components/ui/field'
import {
  InputGroup,
  InputGroupAddon,
  InputGroupButton,
  InputGroupInput,
} from '#/components/ui/input-group'
import { Button } from '#/components/ui/button'
import { login } from '#/lib/api'

export const Route = createFileRoute('/_auth/sign-in')({
  component: RouteComponent,
})

function RouteComponent() {
  const [showPassword, setShowPassword] = useState<boolean>(false)

  const navigate = useNavigate()

  const form = useForm({
    defaultValues: {
      username: '',
      password: '',
    },
    validators: {
      onChange: signInRequestSchema,
      onSubmit: signInRequestSchema,
    },
    onSubmit: async ({ value }) => {
      const { token } = await login(value.username, value.password)
      // localStorage.setItem('auth_token', token)
      toast.success('Login berhasil')
      // await navigate({ to: '/' })
      console.log(token)
    },
  })

  const handleShowPassword = () => {
    setShowPassword((prev) => !prev)
  }

  return (
    <div className="w-full max-w-sm">
      <Card>
        <CardHeader>
          <div className="mb-3.5 flex size-14 items-center justify-center rounded-lg bg-linear-to-br from-g6 to-g4 text-2xl">
            <span>📚</span>
          </div>

          <CardTitle className="text-2xl font-bold">Masuk ke SiRPPH</CardTitle>

          <CardDescription>
            PAUDQu AL-AULIA — Tahun Ajaran {new Date().getFullYear() - 1}/
            {new Date().getFullYear()}
          </CardDescription>
        </CardHeader>

        <CardContent>
          <form
            onSubmit={(e) => {
              e.preventDefault()
              e.stopPropagation()
              void form.handleSubmit()
            }}
          >
            <FieldGroup>
              <form.Field
                name="username"
                children={(field) => {
                  const isInvalid =
                    field.state.meta.isTouched && !field.state.meta.isValid
                  return (
                    <Field data-invalid={isInvalid}>
                      <FieldLabel htmlFor={field.name}>Username</FieldLabel>
                      <InputGroup>
                        <InputGroupAddon>
                          <IconAt />
                        </InputGroupAddon>
                        <InputGroupInput
                          id={field.name}
                          name={field.name}
                          value={field.state.value}
                          onBlur={field.handleBlur}
                          onChange={(e) => field.handleChange(e.target.value)}
                          aria-invalid={isInvalid}
                          placeholder="Masukkan username anda"
                          autoComplete="username"
                          type="text"
                        />
                      </InputGroup>
                      {isInvalid && (
                        <FieldError errors={field.state.meta.errors} />
                      )}
                    </Field>
                  )
                }}
              />

              <form.Field
                name="password"
                children={(field) => {
                  const isInvalid =
                    field.state.meta.isTouched && !field.state.meta.isValid
                  return (
                    <Field data-invalid={isInvalid}>
                      <FieldLabel htmlFor={field.name}>Password</FieldLabel>
                      <InputGroup>
                        <InputGroupAddon>
                          <IconLock />
                        </InputGroupAddon>
                        <InputGroupInput
                          id={field.name}
                          name={field.name}
                          value={field.state.value}
                          onBlur={field.handleBlur}
                          onChange={(e) => field.handleChange(e.target.value)}
                          aria-invalid={isInvalid}
                          placeholder="Masukkan password anda"
                          autoComplete="password"
                          type={showPassword ? 'text' : 'password'}
                        />
                        <InputGroupAddon align="inline-end">
                          <InputGroupButton
                            type="button"
                            onClick={handleShowPassword}
                          >
                            {showPassword ? <IconEyeOff /> : <IconEye />}
                          </InputGroupButton>
                        </InputGroupAddon>
                      </InputGroup>
                      {isInvalid && (
                        <FieldError errors={field.state.meta.errors} />
                      )}
                    </Field>
                  )
                }}
              />
            </FieldGroup>

            <form.Subscribe
              selector={(state) => [state.canSubmit, state.isSubmitting]}
              children={([canSubmit, isSubmitting]) => (
                <Button
                  type="submit"
                  disabled={!canSubmit || isSubmitting}
                  className="mt-4 w-full"
                >
                  {isSubmitting ? 'Loading...' : 'Masuk'}
                </Button>
              )}
            />
          </form>
        </CardContent>
      </Card>
    </div>
  )
}
