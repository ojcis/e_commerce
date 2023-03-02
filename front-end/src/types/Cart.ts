import type { Product } from "@/types/Product";

export interface Cart{
  id: number;
  product: Product[];
  amount: number;
  full_price: number;
}