export interface AuthUser {
  token: string;
  message: string;
  name: string;
  id: number | null;
  admin: boolean;
}