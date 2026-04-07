import { z } from 'zod'

export const signInRequestSchema = z.object({
  username: z.string().nonempty('Username tidak boleh kosong'),
  password: z.string().nonempty('Password tidak boleh kosong'),
})

export type SignInRequestSchema = z.infer<typeof signInRequestSchema>

export const signInResponseSchema = z.object({
  message: z.string(),
  token: z.string().optional(),
  token_type: z.string().optional(),
  user: z.object({
    id: z.number().int(),
    name: z.string(),
    username: z.string(),
    email: z.email(),
    role: z.string(),
    kelas: z.string(),
  }),
})

export type SignInResponseSchema = z.infer<typeof signInResponseSchema>

export const signInErrorSchema = z.object({
  message: z.string(),
  errors: z.record(z.string(), z.array(z.string())),
})

export type SignInErrorSchema = z.infer<typeof signInErrorSchema>

export const sessionSchema = z.object({
  user: z.object({
    id: z.number().int(),
    name: z.string(),
    username: z.string(),
    email: z.email(),
    roles: z.array(z.string()),
    permissions: z.array(z.string()),
  }),
})

export type SessionSchema = z.infer<typeof sessionSchema>
